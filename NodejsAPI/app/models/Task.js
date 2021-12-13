var mongoose = require('mongoose')
const { Schema } = mongoose;

const TaskSchema = new Schema({
    UserId: String,
    Text: String,
    Done: Boolean,
    Date: String
},
{
    collection: "Tasks"
}
);

const Task = mongoose.model("Tasks", TaskSchema)
module.exports = Task