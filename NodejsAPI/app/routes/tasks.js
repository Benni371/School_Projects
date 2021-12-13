const express = require(`express`)
const router = express.Router()

const Task = require(`../models/Task`)

/**
 * GET: Returns one task with the task's id specified in the path
 */
router.get(`/`, async (req, res) => {
	try {
		console.log(req.user)
		//find all tasks by using users id
		const task = await Task.find({UserId: req.user.Id})
		if (!task) res.status(404).send(`Task with ID ${req.params.id} does not exist.`)
		else res.status(200).send(task) // if successful return the tasks to whoever asked
	} catch (error) {
		console.error(error)
		res.status(500).send(`Something went wrong.`)
	}
	
})
router.get(`/:id`, async (req, res) => {
	try {
		// find a specific task by using the task id passed in the url
		const task = await Task.findById({_id: req.params.id})
		if (!task) res.status(404).send(`Task with ID ${req.params.id} does not exist.`)
		else res.status(200).send(task) // if successful return the tasks to whoever asked
	} catch (error) {
		console.error(error)
		res.status(500).send(`Something went wrong.`)
	}
	
})
router.post(`/`, async (req, res) => {
	try {
		//grab all the data passed in the body to then send to mongo
		var data  ={
			UserId: req.user.Id,
			Done: false,
			Text: req.body.Text,
			Date: req.body.Date
		}
		//if there is blank input send an error status
		if (data.Text == "" || data.Date == "")
		{
			
			return res.status(500).send("Not enough data")
		}
		const task = await new Task(data)
		await task.save()
		res.status(201).send("task created")
	} catch (error) {
		console.error(error)
		res.status(500).send(`Something went wrong.`)
	}
})
router.put(`/:id`, async (req, res) => {
	try {
		//find a task and update its done value to false or true according to the request body
        const allTasks = await Task.findByIdAndUpdate(req.params.id,{Done: req.body.Done}, {new: true});
		if(!allTasks) res.status(404).send(`Task with ID ${req.params.id} does not exist`)
        else res.status(201).send(allTasks);// if successful return the updated to whoever asked
	} catch (error) {
		console.error(error)
		res.status(500).send(`Something went wrong.`)
	}
})
router.delete(`/:id`, async (req, res) => {
	try {
		// find a task by its id and delete it
		const task = await Task.deleteOne({_id: req.params.id})
		if(task["deletedCount"] === 0) res.status(`Task ID: ${req.params.id} is not valid`)
		res.status(200).send("Task Deleted Successfully")
	} catch (error) {
		console.error(error)
		res.status(500).send(`Something went wrong.`)
	}
})

module.exports = router