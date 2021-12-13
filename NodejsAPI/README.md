# Lab-6-Boilerplate
## Overview ##
The base url for this project was `http://localhost:1337` and the endpoints will build off this base url. The project is a basic todo list and includes endpoints to modify this data
## Endpoints ##
### `/tasks/` ###
The overall purpose of this endpoint is to create, modify and delete from an authorized users list of tasks.
<table>
<tr>
<th>Endpoint</th>
<th>Description</th>
<th>Parameters</th>
<th>Example</th>
<th>Response</th>

</tr>
<tr>
    <td><code>GET: /tasks/</code></td>
    <td>Gets all the users tasks</td>
    <td>none</td>
    <td>http://localhost:1337/tasks/ </td>
<td>

```json
    {
        "_id": "6182c0d1da67e690676a7d16",
        "UserId": "TEST",
        "Text": "get groceries",
        "Done": true,
        "Date": "1111-11-11"
    }

```
    
    
</td>
    
</tr>
<tr>
    <td><code>GET: /tasks/:id</code></td>
    <td>Gets one task based on the task id</td>
    <td>_id</td>
    <td> http://localhost:1337/tasks/1jkdadsafklj34jddfsfs34</td>
<td>

```json
    {
        "_id": "6182c0d1da67e690676a7d16",
        "UserId": "TEST",
        "Text": "get groceries",
        "Done": true,
        "Date": "1111-11-11"
    }

```
    
</td>
    
</tr>
<tr>
    <td><code>POST: /tasks/</code></td>
    <td></td>
    <td> none </td>
    <td>HTTPBody needs <code>UserId,Text,Done,_id,__v</code>

```json
{
    "Text":"go to store",
    "Done":"false"
}
```

</td>
<td>"Task Created"</td>
    
</tr>
<tr>
    <td><code>PUT: /tasks/:id</code></td>
    <td>Update task to done or not done</td>
    <td>Done</td>
<td>

```json
{   
    //can be true or false when sent
    "Done": "true"
}
```

         

</td>
<td>

```json
{
    "_id": "6182c0d1da67e690676a7d16",
    "UserId": "TEST",
    "Text": "get groceries",
    "Done": true,
    "Date": "1111-11-11"
}
```

</td>


</tr>
<tr>
    <td><code>DELETE: /tasks/:id</code></td>
    <td>Deletes one task based on the id given</td>
    <td>_id</td>
    <td></td>
    <td>Task deleted Succesfully</td>
</tr>
</table>

### `/user/` ###
<table>
<tr>
<th>Endpoint</th>
<th>Description</th>
<th>Parameters</th>
<th>Example</th>
<th>Response</th>

</tr>
<tr>
<td><code>GET: /user/</code></td>
<td>Retrieves the current user profile</td>
<td>none</td>
<td>http://localhost:1337/user</td>
<td>Will return: <code>UserName, Email</code></td>
</tr>
</table>
  

### `/auth/` ###
<table>
<tr>
<th>Endpoint</th>
<th>Description</th>
<th>Parameters</th>
<th>Example</th>
<th>Response</th>
</tr>
<tr>
<td><code>GET: /user/google</code></td>
<td>Authentication via gmail account</td>
<td>none</td>
<td>http://localhost:1337/auth/google</td>
<td></td>
</tr>
</tr>
<tr>
<td><code>GET: /user/google/callback</code></td>
<td>Used in Google Developer console and will be invoked by the API method you're calling after the method has executed</td>
<td>none</td>
<td>http://localhost:1337/auth/google/callback</td>
<td></td>
</tr>
</tr>
<tr>
<td><code>GET: /auth/logout</code></td>
<td>Logs the user out</td>
<td>none</td>
<td>http://localhost:1337/auth/logout</td>
<td></td>
</tr>
</table>
