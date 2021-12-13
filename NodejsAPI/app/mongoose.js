var mongoose = require("mongoose");

main().catch(err => console.log(err));
async function main() {
  //creates a connection with the mongo db database listed in the .env file
  await mongoose.connect(process.env.ATLAS_CONNECTION_STRING);
  console.log("MongoDb connected")
}