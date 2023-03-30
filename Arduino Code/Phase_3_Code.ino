#include <Wire.h>
#include <MPU6050.h>

MPU6050 mpu;

const int buffer_size = 1000;
unsigned long start_time;
float dt = 0.001; // time step in seconds
float displacement = 0;
float velocity = 0;

void setup() {
  Serial.begin(115200);

  // Initialize MPU6050 sensor
  Wire.begin();
  mpu.initialize();
  mpu.setFullScaleGyroRange(2);
  mpu.setFullScaleAccelRange(3);
}

void loop() {
  static int sample_count = 0;
  static int buffer_capacity = buffer_size;
  static float *rhos = new float[buffer_capacity];
  static float *thetas = new float[buffer_capacity];
  static float *phis = new float[buffer_capacity];
  static float *times = new float[buffer_capacity];
  static float *velocities = new float[buffer_capacity];
  static float *displacements = new float[buffer_capacity];
  
  // Get raw sensor data
  int16_t ax, ay, az, gx, gy, gz;
  mpu.getMotion6(&ax, &ay, &az, &gx, &gy, &gz);
  
  // Compute magnitudes of acceleration and angle from the z-axis
  float accel_magnitude = sqrt(ax * ax + ay * ay + az * az);
  float theta = atan2(sqrt(ax * ax + ay * ay), az);
  float phi = atan2(ay, ax);
  
  // Integrate acceleration to get velocity
  velocity += accel_magnitude * dt;
// Integrate velocity to get displacement
  displacement += velocity * dt;
  
  // Save data to buffers
  rhos[sample_count] = accel_magnitude;
  thetas[sample_count] = theta;
  phis[sample_count] = phi;
  times[sample_count] = (millis() - start_time) / 1000.0; // convert to seconds
  velocities[sample_count] = velocity;
  displacements[sample_count] = displacement;
  
  // Resize buffers if needed
  sample_count++;
  if (sample_count == buffer_capacity) {
    buffer_capacity += buffer_size;
    rhos = (float*)realloc(rhos, buffer_capacity * sizeof(float));
    // thetas = (float*)realloc(thetas, buffer_capacity * sizeof(float));
    // phis = (float*)realloc(phis, buffer_capacity * sizeof(float));
    // times = (float*)realloc(times, buffer_capacity * sizeof(float));
    // velocities = (float*)realloc(velocities, buffer_capacity * sizeof(float));
    // displacements = (float*)realloc(displacements, buffer_capacity * sizeof(float));
 }

  Serial.print(rhos[sample_count]);
  Serial.print(",");
  // Serial.print(thetas[sample_count]);
  // Serial.print(",");
  // Serial.print(phis[sample_count]);
  // Serial.print(",");
  // Serial.print(times[sample_count]);
  // Serial.print(",");
  // Serial.print(velocities[sample_count]);
  // Serial.print(",");
  // Serial.println(displacements[sample_count]);

  // Check if displacement has reached 10 meters, stop recording if so
  if (displacement >= 10) {
    exit(1);
  }
}
