# Overview #
This repository contains code used to test endpoints listed in the table below. The `api.py` file contains functions that make http requests to the specified website. Each function has its own headers and data that it will need in order to successfully make a request to the endpoint. The `test_api.py` file contains functions that test the functions and requests contained in `api.py`. Each function has a short description of what it does and how it accomplishes its task. 
| HTTP Method | Endpoint                 | Expected Response   | Headers             | Body      |
|-------------|--------------------------|---------------------|---------------------|-----------|
| GET         | `api/v1/auth/google`     | Google Login page   | none                | none      |
| POST        | `api/v1/tasks`           | New created task    | Content-Type, Cookie | Text, Date |
| GET         | `api/v1/tasks`           | List of tasks       | Cookie              | none      |
| GET         | `api/v1/tasks/[task_id]` | Single task         | Cookie              | none      |
| PUT         | `api/v1/tasks/[task_id]` | Updated task        | Content-Type, Cookie | Done      |
| DELETE      | `api/v1/tasks/[task_id]` | Confirm delete task | Cookie              | none      |
| GET         | `api/v1/user`            | Logged in user info | Cookie              | none      |
## Retrieving Session Cookie ##
In order to use these test functions you will first need a session cookie. This can be obtained by appending `/api/v1/auth/google` to the site you are trying to test and then going into the developer tools. For example, if you wanted to test `http://210s2.itcyber.byu.edu` endpoints you would enter in `http://210s2.itcyber.byu.edu/api/v1/auth/google` after which you hit `F12` and find the application tab in tools section. After that find the cookies subsection and find the `it210_session` name and copy its value (it usually starts with `s%`). You will need a separate cookie for each site so you will need to go to each sites google authentication page in order to get a new cookie. 
## Running the Code ##
Once you have the cookie, you can now either test the functions in `api.py` or test the endpoints in `test_api.py`. To test, you will need to paste your cookie in the `cookie` variable in either `api.py` or `test_api.py`. Once its pasted, make sure that only the `base_url` and `cookie` variables for the site you are testing are uncommented, otherwise the code will not work properly. After those are set properly, you can now execute the code through the command line. If you want to test the functions in `api.py` you will have to enter the parameters in manually. If you want to test the endpoints in `test_api.py`, the parameters are automatically generated for you.
## Future Improvements ##  
If in the future, you would like to add more functionality to the requests or other things the main file that you would do that in would be the `api.py` since that file is the main part of the code. If you want to test new endpoints or such the `test_api.py` file would be the file that you would change.