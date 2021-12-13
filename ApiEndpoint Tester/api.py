#!/usr/bin/env python3
from urllib.parse import urljoin
import requests

class API(object):

    def __init__(self, base_url):
        """ Creates the API client.
        Paramaters:
            base_url (str): The base url for the API.
        Returns:
            New API class for testing an API.
        """
        self.base_url = base_url
    def get_googled(self):
        url = urljoin(self.base_url, "api/v1/auth/google")
        response = requests.request("GET", url)
        return response


    def create_task(self, cookie, Text, Date):
        """ Create a new task
        Parameters:
            cookie (str): Pre-authorized cookie
            Text (str): Text/description of the task.
            Date (str): Due date of the task
        Returns:
            Response from the server
        """
        url = urljoin(self.base_url, "api/v1/tasks")
        data = '{ "Text": "%s", "Date": "%s" }' % (Text, Date)
        headers = {
            'Content-Type': 'application/json',
            'Cookie': 'it210_session=' + cookie
        }
        response = requests.request("POST", url, headers=headers, data=data)
        return response

    def read_all_tasks(self, cookie):
        """Read all tasks associated with user
        Parameters:
            cookie (str): Pre-authorized cookie
        Returns:
            Response from the server
        """
        url = urljoin(self.base_url, "api/v1/tasks")
        headers = {
            'Cookie': 'it210_session=' + cookie
        }
        response = requests.request("GET", url, headers=headers)
        return response
        

    def read_task(self, cookie, task_id):
        """Read one specific task 
        Parameters:
            cookie (str): Pre-authorized cookie
            task_id (str): id of specified task
        Returns:
            Response from the server
        """
        url = urljoin(self.base_url, "api/v1/tasks/" + task_id)
        headers = {
            'Cookie': 'it210_session=' + cookie
        }
        response = requests.request("GET", url, headers=headers)
        return response

    def update_task(self, cookie, task_id, Done):
        """Update one tasks status to done or not done
        Parameters:
            task_id (str): id of specified task
            cookie (str): Pre-authorized cookie
            Done (bool): true (completed) or false (incomplete)
        Returns:
            Response from the server
        """
        url = urljoin(self.base_url, "api/v1/tasks/" + task_id)
        Done = str(Done)
        data = '{ "Done": "%s"}' % (Done.lower())
        headers = {
            'Content-Type': 'application/json',
            'Cookie': 'it210_session=' + cookie
        }
        response = requests.request("PUT", url, headers=headers, data=data)
        return response

    def delete_task(self, cookie, task_id):
        """Delete specific task
        Parameters:
            cookie (str): Pre-authorized cookie
            task_id (str): id of specified task
        Returns:
            Response from the server
        """
        url = urljoin(self.base_url, "api/v1/tasks/" + task_id)
        headers = {
            'Cookie': 'it210_session=' + cookie
        }
        response = requests.request("DELETE", url, headers=headers)
        return response

    def read_current_user(self, cookie):
        """Return the current user
        Parameters:
            cookie (str): Pre-authorized cookie
        Returns:
            Response from the server
        """
        url = urljoin(self.base_url, "api/v1/user")
        headers = {
            'Cookie': 'it210_session=' + cookie
        }
        response = requests.request("GET", url, headers=headers)
        return response
        

if __name__ == "__main__":
    # Remember, this section of code is for you. Do with
    # it what you will, to see what the code looks like
    # for different requests. You may add more api calls
    # or remove them. I have found that if I add too
    # many `print()`s, the output becomes overloaded and
    # unhelpful, but again, this is personal preference.
    base_url,cookie = "https://210s1.itcyber.byu.edu/","s%3A0..."    # For s1
    # base_url, cookie = "http://210s2.itcyber.byu.edu", "s%3Adq..." # For s2
    # base_url, cookie = "http://210s3.itcyber.byu.edu", "s%3A-t..." # For s3
    # base_url, cookie = "http://210s4.itcyber.byu.edu", "s%3AJi..." # For s4
    api = API(base_url)
    # print("----------Running Test on Get GOOGled----------")
    # response = api.get_googled()
    # print(response.ok)
    # print(response.status_code)
    # print("----------Running Test on Create Task----------")
    # response = api.create_task(cookie, "Test the API", "2020-02-20")
    # print(response.ok)
    # print(response.status_code)
    # print("----------Running Test on Update Task----------")
    # response = api.update_task(cookie, taskID, True)
    # print(response.ok)
    # print(response.status_code)
    # print("----------Running Test on Read all Tasks-----------")
    # response = api.read_all_tasks(cookie)
    # print(response.ok)
    # print(response.status_code)
    # print("----------Running Test on Read One Task-----------")
    # response = api.read_task(cookie, taskID)
    # print(response.ok)
    # print(response.status_code)
    # print("----------Running Test on Delete Task-----------")
    # response = api.delete_task(cookie, taskID)
    # print(response.ok)
    # print(response.status_code)
    # response = api.read_all_tasks(cookie)
    # print("----------Running Test on Read Current User-----------")
    # response = api.read_current_user(cookie)
    # print(response.ok)
    # print(response.status_code)


