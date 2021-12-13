// script.js: BYU IT&C 210a JavaScript

class Task {
    constructor({ text, date, done, id }) {
        this.text = text
        this.date = date
        this.done = done
        this.id = id
    }
    toHTML() {
        
        return `<li id="${this.id}" class="task"><input class="task-done checkbox-icon"  type="checkbox" name="chkbx1" onclick="updateTask(${this.id})" ${this.done ? 'checked' : ''}><span ><label class="task-description ${this.done ? 'completed' : ''}" for="chkbx1">${this.text} </label><label class="task-date ${this.done ? 'completed' : ''}">${this.prettyDate()}</label></span><button class="task-delete material-icon" onclick="deleteTask(${this.id})">remove_circle</button></li>
`   
    }
    prettyDate() {
        try {
            let arr = this.date.split('-')
            if(arr[0] == null)
            {
                let arr = this.date.split('/')
                return arr[2] + "/" + arr[0] + "/" + arr[1]
            }
            else{
                return arr[1] + "/" + arr[2] + "/" + arr[0]
            }
        } 
        catch (error) {
            window.alert("Date conversion error")
        }
    }
    toggle() {        
        return !this.done
    }
}

let tasks = [
    new Task({
        text: "First task",
        done: false,
        date: "2020-02-10",
        id: Date.now() // makes a unique id
    })
]
let SortedDates = []
let SortedComp = []
let Sorted = []
function toggleCheck(){
    let arr1 = []
    let arr2 = []
    let arr = []
    // sortbox is checked and compbox checked
    if(document.getElementById("sortBox").checked === true && document.getElementById("compBox").checked === true){
        sortCompleted(tasks)
        sortDate(SortedComp)
        Sorted = SortedDates
        readTasks(1)
      }
    else if(document.getElementById("sortBox").checked === false && document.getElementById("compBox").checked === true) {   
        // sortbox is not checked and compbox is checked
        sortCompleted(tasks)
        Sorted = SortedComp
        readTasks(1)
      }
    else if(document.getElementById("sortBox").checked === true && document.getElementById("compBox").checked === false) {   
        //only sortbox is checked
        sortDate(tasks)
        Sorted = SortedDates
        readTasks(1)
    }
    else{
        //if both false then read storage as normal
        readStorage()
    }
}


function sortCompleted(arr){
    //returns everything that is not done
        SortedComp = arr.filter(task => task.done == false)
}
function sortDate(arr)
{
    SortedDates = arr.slice().sort(function(a,b){
        return new Date(a.date) - new Date(b.date)
    });
    

}

function clearForm(){
    let text = document.getElementById('details')
    let date = document.getElementById('date')

    text.value = ""
    date.value = ""
    localStorage.setItem("TState", text.value )
    localStorage.setItem("DState", date.value )

}
function isValid(otherData){
    if(otherData.date == ""){
        window.alert("Please enter a Date!")
        return false;
    } 
    return true;
}
function isTreachery(text){
    let test = ""
    for (let i = 0; i < text.length; i++) {
         switch (text.at(i)) {
             case "<":
                test = text.replace("<", "&lt")
                text = test
                break
             case ">":
                test = text.replace(">", "&gt")
                text = test
                break
             case "&":
                test = text.replace("&", "&amp")
                text = test
                break
             default:
                test = text
                break;
         }
    }
    return test;
}
function StoreCurrent(){
    let text = document.getElementById('details').value
    let date = document.getElementById('date').value

    localStorage.setItem("TState", text )
    localStorage.setItem("DState", date )
}
function ReadCurrent(){
    let text = document.getElementById('details')
    let date = document.getElementById('date')

    text.value = localStorage.getItem("TState")
    console.log(text)
    date.value = localStorage.getItem("DState")
    console.log(date)
}
function createTask(event) {
    
    let formData = new FormData(event.currentTarget);
    let otherData =  Object.fromEntries(formData)
    otherData.text = isTreachery(otherData.text)
    if(isValid(otherData)){
    //add other data to fill object
    let newTask = new Task({text: otherData.text, date: otherData.date, done: false, id: Date.now()})
    updateStorage(newTask);
    tasks.push(newTask)
    readTasks(0);
    clearForm()
    event.preventDefault();
    }
    else{
        //do nothing
    }
}

function updateStorage(newData) {
    //get old database and append
    var allEntries = JSON.parse(localStorage.getItem('database')) || [];
    allEntries.push(newData);
    let json = JSON.stringify(allEntries);
    localStorage.setItem('database', json )
    // ... update the local storage
}

function readStorage() {
    //make sure the database is set correctly
    if(localStorage.getItem('database') == "{}" || localStorage.getItem('database') == null || localStorage.getItem('database') == "undefined" )
    {
        localStorage.setItem('database', "[]")
    }
    let jsonString = localStorage.getItem('database')
    let result = JSON.parse(jsonString) || []    
    result = result.map((taskData) => 
    {
        return new Task({ text: taskData.text, date: taskData.date, done: taskData.done, id: taskData.id })
    });
    tasks = result;
    readTasks(0);
}

function readTasks(num) {
    if(num === 1){
        let html = "";
    var i=0;
    while(i < Sorted.length){
        html += Sorted[i].toHTML()
        i++;
    }
    document.getElementById('taskList').innerHTML = html
    }
    else{
    let html = "";
    var i=0;
    while(i < tasks.length){
        html += tasks[i].toHTML()
        i++;
    }
    document.getElementById('taskList').innerHTML = html
}
}

function updateTask(id) {  
    for(let i = 0; i < tasks.length; i ++)
    {
        if(tasks[i].id === id)
        {
            tasks[i].done = tasks[i].toggle()
            flipTask(tasks[i])
            // if(document.getElementById("sortBox").checked === true){
            //     readSortedTasks();
            //     break;
            // }
            readTasks();
            break;
        }
    }
function flipTask(taskData)
{
    //find the matching ids and set the data
    let allEntries = JSON.parse(localStorage.getItem('database'))
    for (let index = 0; index < tasks.length; index++) {
        if(allEntries[index].id == taskData.id){
            allEntries[index].done = taskData.done
        }
    }
    let json = JSON.stringify(allEntries);
    localStorage.setItem('database', json )
    readStorage();
} 
}
function deleteTask(id) {
    for(let i = 0; i < tasks.length; i++)
    {
        if(tasks[i].id === id)
        {   
            let allEntries = JSON.parse(localStorage.getItem('database'))
            if(allEntries[i].id == tasks[i].id){
                allEntries.splice(i, 1)
                let json = JSON.stringify(allEntries);
                localStorage.setItem('database', json )
            }
        let json = JSON.stringify(allEntries);
        localStorage.setItem('database', json )
        tasks.splice(i,1)
        }
    }
    document.getElementById(id).remove();
}