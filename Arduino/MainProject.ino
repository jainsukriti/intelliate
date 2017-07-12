/*
 NodeMCU ->  4051
 -----------------
 D4    ->   S0 (A)
 D3    ->   S1 (B)
 D2    ->   S2 (C)
 A0    ->   Common
 3.3v  ->   VCC
 G     ->   GND
 G     ->   Inhibit
 G     ->   VEE  


 NodeMCU ->  DHT11
 -----------------
 VCC    ->   PIN 1
 D5     ->   PIN 2 
 GND    ->   PIN 4

 Audio  ->  4051
 -----------------
 VCC    ->   VCC
 GND    ->   GND
 OUT    ->   PIN 14

  Pulse ->  4051
 -----------------
 VCC    ->   VCC
 GND    ->   GND
 OUT    ->   PIN 13

*/



#include <ESP8266WiFi.h>
#include <FirebaseArduino.h>
#include <DHT.h>

#define FIREBASE_URL "mainproject-XYZ.firebaseio.com"
#define FIREBASE_KEY "733b3ef1325b61b5f8bd8983ba438a0333796b4b"

#define WIFI_SSID "EvilCorp"
#define WIFI_PASS "amalmurali.me"

#define DHTTYPE DHT11
#define DHTPIN D5

#define S0 D4
#define S1 D3
#define S2 D2

#define ANALOG_INPUT A0

DHT dht(DHTPIN, DHTTYPE, 11);

int notConnected = LED_BUILTIN;

void setupWiFi(){
  Serial.println("\nConnecting...");
  WiFi.begin(WIFI_SSID, WIFI_PASS);

  while(WiFi.status() != WL_CONNECTED){
    Serial.print(".");
    digitalWrite(notConnected, LOW);
    delay(500);
  }

  Serial.println("\nConnected : ");
  Serial.println(WiFi.localIP());
  digitalWrite(notConnected,HIGH);

}

void setupFirebase(){
  Firebase.begin(FIREBASE_URL, FIREBASE_KEY);
}

void setup(){
  pinMode(S0, OUTPUT);
  pinMode(S1, OUTPUT);     
  pinMode(S2, OUTPUT);

  pinMode(notConnected,OUTPUT);
  
  Serial.begin(9600);
  dht.begin();
  setupWiFi();
  setupFirebase();
}

float readHeartBeat(){
  digitalWrite(S0, LOW);
  digitalWrite(S1, LOW);
  digitalWrite(S2, LOW);
  return analogRead(ANALOG_INPUT);
}

float readAudio(){
  digitalWrite(S0, HIGH);
  digitalWrite(S1, LOW);
  digitalWrite(S2, LOW);
  return map(analogRead(ANALOG_INPUT),1032,0,0,1023);
}

float readLight(){
  digitalWrite(S0, LOW);
  digitalWrite(S1, HIGH);
  digitalWrite(S2, LOW);
  return map(analogRead(ANALOG_INPUT),0,1023,0,100);
}

void loop(){
  int audio = readAudio();
  int heartBeat = readHeartBeat();
  int light = readLight();
  int humidity = dht.readHumidity();
  int temperature = dht.readTemperature();
 
  Serial.print("Audio: ");
  Serial.print(audio);
  Serial.print("\tHeartBeat: ");
  Serial.print(heartBeat);
  Serial.print("\tLight: ");
  Serial.print(light);
  Serial.print("\tHumidity: ");
  Serial.print(humidity); 
  Serial.print("\tTemperature: ");
  Serial.println(temperature);

  Firebase.setFloat("audio/lastAudio", audio);
  Serial.print(Firebase.success());
  Firebase.pushFloat("audio", audio);
  Serial.print(Firebase.success());

  Firebase.setFloat("heartBeat/lastHeartBeat", heartBeat);
  Serial.print(Firebase.success());
  Firebase.pushFloat("heartBeat", heartBeat);
  Serial.print(Firebase.success());

  Firebase.setFloat("lightIntensity/lastLightIntensity", light);
  Serial.print(Firebase.success());
  Firebase.pushFloat("lightIntensity", light);
  Serial.print(Firebase.success());

  Firebase.setFloat("humidity/lastHumidity", humidity);
  Serial.print(Firebase.success());
  Firebase.pushFloat("humidity", humidity);
  Serial.print(Firebase.success());

  Firebase.setFloat("temperature/lastTemperature", temperature);
  Serial.print(Firebase.success());
  Firebase.pushFloat("temperature", temperature);
  Serial.println(Firebase.success());

  if(Firebase.failed()){
    Serial.println(Firebase.error());
  }
 
  
}