# Degree Project
Project made by Óscar, Cristian and Rubén.

In this repository you will find two main folders:
In the "asix-project" folder are the files belonging to the other services, now built using Docker containers.
In order to start the containers, from the asix-project folder we can execute:
		sudo docker-compose up
In the "app" folder are all the files hosted in the home of our user "raspy". Inside there will be a directory called "def" or definitive. If we open it we will find the logs directory, the reports directory, the credentials directory and the scripts directory, where our application will be together with a file to do tests.
You can run the application once the Docker containers have been built with the command:
		sudo python3 scriptcreoquesi.py
