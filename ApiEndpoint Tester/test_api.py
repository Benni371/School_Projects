#!/usr/bin/env python3
import random
import string
import unittest
from api import API


def generate_hex(l):
    """Helper to generate randome hex characters to test invalid
    ids and task ids
    """
    chars = string.hexdigits
    return "".join(random.choice(chars) for i in range(l)).lower()

def generate_random_text(l=10):
    """ Helper to generate random text for creating new tasks.
    This is helpful and will ensure that when you run your tests,
    a new text string is created. It is also good for determining
    that two tasks are unique.
    Keyword arguments:
        l (int): How long the generated text should be (default 10)
    Returns:
        A randomly-generated string of length `l`
    """
    chars = string.hexdigits
    return "".join(random.choice(chars) for i in range(l)).lower()


def generate_random_date(year=None, month=None, date=None):
    """ Helper to generate random date for creating new tasks.
    This is helpful as another way of generating random tasks
    Keyword arguments:
        year: Specify a year (default None)
        month: Specify a month (default None)
        date: Specify a date (default None)
    Returns:
        A randomly-generated string representation of a date
    """
    if not year:
        year = str(random.randint(2000, 2025))
    if not month:
        month = str(random.randint(1, 12))
    if not date:
        date = str(random.randint(1, 28))
    return str(year) + "-" + str(month).zfill(2) + "-" + str(date).zfill(2) + "T00:00:00.000Z"


class TestAPI(unittest.TestCase):

    # TODO: update the cookie value and uncomment the desired `base_url, cookie` pair when ready to test
    #base_url, cookie = "https://210s1.itcyber.byu.edu", "s%3A0KpTQi8bOjGJo7gBMQrCuHILIrl9YjP6.Kim3MEhs2OiiEDZpveEWvybFUP4VlGieFLq%2BRN6j9Ec" # For s1
    #base_url, cookie = "https://210s2.itcyber.byu.edu", "s%3A1dFqXkTgaeQwX4IZl4Lbfn0UeTv_6lbN.TXA39BKm3FkS0CXGa1JFMkNEKk01QuIxKKq3%2F66v1ko" # For s2
    #base_url, cookie = "https://210s3.itcyber.byu.edu", "s%3AYEyft1-Objwqo-uiqRTLYQMsyM7oXS52.8SIjVEgaQSM6JGx6PZMDdiVt4%2FczE9Lx3nlDO%2F%2Bm9DA" # For s3
    base_url, cookie = "https://210s4.itcyber.byu.edu", "s%3Aazjdg66AC6-shEmxr-7mIO25aOMAe5HJ.raHH%2Fw0dC4srqWiHdJFsXzF5znnuOA7r25bbGkT6g0w" # For s4

    @classmethod
    def setUpClass(self):
        super().setUpClass()
        self.api = API(self.base_url)

    def test_create_task(self):
        """ Tests creating a task is successful.
        This is an example test:
            - Create the task w/dummy data
            - Verify that the task was created
            - Delete the task we created
        You will be required to implement the other tests
        that are defined in BaseTestCase. They will be marked
        with @abc.abstractmethod.
        """
        Text = generate_random_text()
        Date = generate_random_date()
        resp = self.api.create_task(self.cookie, Text, Date)
        self.assertTrue(resp.ok, msg=f"The Create Task failed: {resp.reason}")
        task = resp.json()

        self.assertEqual(task["Text"], Text, msg="The task's Text did not match the expected Text.")
        self.assertEqual(task["Date"], Date, msg="The task's Date did not match the expected Date.")
        self.assertFalse(task["Done"], msg="The task's Done returned True, expected False.")
        self.assertIn("UserId", task, msg="All tasks should have a UserId, matching the Id of the user who created it.")
        self.api.delete_task(self.cookie, task["_id"])

    def test_missing_create_data(self):
        """ Tests creating a task without a date or text.
        This is an example test:
            - Create the task with empty date and text
            - Verify that the error was 500
        """
        Text = ""
        Date = ""
        resp = self.api.create_task(self.cookie, Text, Date)
        sc = resp.status_code
        self.assertEqual(sc, 500 , msg=f"The error code was {sc} not 500")

    def test_read_one_notexist(self):
        """ Tests reading one task that doesnt exist.
        This is an example test:
            - generate a random hex id
            - try to read the task
        """
        randID = generate_hex(24)
        self.assertFalse(self.api.read_task(self.cookie, randID), msg=f"RandID: {randID} read successfully? But why?")
    
    def test_delete_nonexistent(self):
        """ Tests deleting a task that doesnt exist.
        This is an example test:
            - Create the task with empty date and text
            - Verify that the error was 500
        """
        randID = generate_hex(24)
        self.assertFalse(self.api.read_task(self.cookie, randID), msg="Task deleted? How?")

    def test_delete_invalid_id(self):
        """ Tests deleting a task with and invalid hex ID
            - generate random hex id
            - try to delete the task
        """
        randID = generate_hex(23)
        resp = self.api.delete_task(self.cookie, randID)
        sc = resp.status_code
        self.assertEqual(sc, 500 , msg=f"The error code was {sc} not 500")
        #self.assertFalse(self.api.delete_task(self.cookie, randID), msg="Task deleted? How?")

    
    def test_update_nonexistent(self):
        """ Tests updating a nonexistent task
            - generate random hex id
            - try to update the task
        """
        randID = generate_hex(24)
        self.assertFalse(self.api.update_task(self.cookie, randID, True), msg="Update somehow worked")
    
    def test_read_all_no_cookie(self):
        """Tests reading all tasks without a cookie
            - try to read all tasks by passing in a null cookie
        """
        self.assertFalse(self.api.read_all_tasks("10"), msg="Somehow it read all of them?")

    def test_read_one_task(self):
        """ Tests if reading one task is successful.
        This is an example test:
            - create a task w dummy data
            - get the tasks id
            - check if ids are the same
            - check if text and date are the same
            - check if done is false
            - try to read random task
            - delete task
        """
        # create new task
        Text = generate_random_text()
        Date = generate_random_date()
        resp = self.api.create_task(self.cookie, Text, Date)
        self.assertTrue(resp.ok, msg=f"The Create Task failed: {resp.reason}")
        task = resp.json()
        self.assertEqual(task["Text"], Text, msg="The task's Text did not match the expected Text.")
        self.assertEqual(task["Date"], Date, msg="The task's Date did not match the expected Date.")
        taskID = task["_id"]
        # read the newly created task
        read = self.api.read_task(self.cookie, taskID)
        readID = read.json()
        # check if the ids match, check if done == false, check if randID can be read
        self.assertEqual(taskID,readID["_id"] , msg=f"Task id: {readID} did not match the expected id {taskID}")
        self.assertEqual(task["Done"], False, msg="Done was not set to false")
        self.assertIn("UserId", task, msg="UserID is not set!")

    def test_update_task(self):
        """ Tests if updating a task works.
        This is an example test:
            - create a task w dummy data
            - get the tasks id
            - check if done is originally false
            - check if update task changes the done value
            - delete task
        """
        Text = generate_random_text()
        Date = generate_random_date()
        resp = self.api.create_task(self.cookie, Text, Date)
        task = resp.json()
        self.assertEqual(task["Done"], False, msg="Done was not set to false")
        check = self.api.update_task(self.cookie, task["_id"], True)
        #check = self.api.read_task(self.cookie, task["_id"])
        updated = check.json()
        self.assertEqual(updated["Done"], True, msg="Done value is not set to true")
        self.api.delete_task(self.cookie, task["_id"])

    
    def test_delete_task(self):
        """Tests deleting a task
            - create a task w dummy data
            - Delete task
            - Try to read deleted task to make sure it deleted
        """
        Text = generate_random_text()
        Date = generate_random_date()
        resp = self.api.create_task(self.cookie, Text, Date)
        task = resp.json()
        self.assertTrue(self.api.delete_task(self.cookie, task["_id"]), msg="Task did not delete")
        self.assertFalse(self.api.read_task(self.cookie, task["_id"]), msg="Task deleted? How?")


    def test_read_current_user(self):
        """Tests if user data exists
            - call the function and analyze response data
        """
        resp = self.api.read_current_user(self.cookie)
        user = resp.json()
        self.assertIn("Id", user, msg="User Id is not found")
        self.assertIn("UserName", user, msg="Username is not found")
        self.assertIn("Email", user, msg="Email Id is not found")

    def test_read_all_tasks(self):
        """Tests reading all a users tasks
            - create a dummy task to grab the user id
            - use userId to try and read all the tasks
        """
        Text = generate_random_text()
        Date = generate_random_date()
        resp = self.api.create_task(self.cookie, Text, Date)
        task = resp.json()
        if self.assertIn("UserId", task, msg="All tasks should have a UserId, matching the Id of the user who created it."):
            userID = task["UserId"]
            resp = self.api.read_all_tasks(self.cookie)
            list = resp.json()
            for i in list:
                self.assertEqual(i["UserId"], userID, msg="Ids did not match!")
        else:
            self.assertIn("UserId", task, msg="All tasks should have a UserId, matching the Id of the user who created it.")

if __name__ == "__main__":
     unittest.main()
