# Banktpmm Setup

1.Install XAMPP

[https://www.apachefriends.org/](https://www.apachefriends.org/)

2.Install PHP composer

[https://getcomposer.org/](https://getcomposer.org/)

3.Install NodeJS (for npm)

[https://nodejs.org/en/download/](https://nodejs.org/en/download/)

4.Install Terminal for Windows

-[https://apps.microsoft.com/store/detail/windows-terminal/9N0DX20HK701?hl=en-sg&gl=sg&rtc=1](https://apps.microsoft.com/store/detail/windows-terminal/9N0DX20HK701?hl=en-sg&gl=sg&rtc=1)

5.Install VSCode (if you don't have one yet)

[https://code.visualstudio.com/download](https://code.visualstudio.com/download)

6.Install MySQL Workbench

[https://dev.mysql.com/downloads/workbench/](https://dev.mysql.com/downloads/workbench/)

7.Install NoSQL Workbench

(select the option to install DynamoDB Local)

[https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/workbench.settingup.html](https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/workbench.settingup.html)

8.Setup DynamoDB

- Download AWS CLI

[https://aws.amazon.com/cli/](https://aws.amazon.com/cli/)

- Download JavSDK

[https://www.oracle.com/sg/java/technologies/downloads/#jdk19-windows](https://www.oracle.com/sg/java/technologies/downloads/#jdk19-windows)

- Open NoSQL Workbench (downloaded at step 7)
- Start DB local server (make sure you have JVM - JavaSDK)

![](RackMultipart20230112-1-xzd6k_html_47edbeb602e5a3b1.png)

- Go to DataModeller and click on "Import NoSQL Workbench Model JSON"

![](RackMultipart20230112-1-xzd6k_html_4d0fb29b691db983.png)

- Download this JSON file and Import

[https://drive.google.com/file/d/1QP3T6cGv4hAYLdni\_xmopzwdLlsG\_l3E/view?usp=share\_link](https://drive.google.com/file/d/1QP3T6cGv4hAYLdni_xmopzwdLlsG_l3E/view?usp=share_link)

- Click on "Visualise data Model"
- Click on "Commit to Amazon DynamoDB" -\> select "Local Dynamodb"
- Go to "Operation Builder" and setup LocalDB connection

![](RackMultipart20230112-1-xzd6k_html_977f5b377bd5f20e.png)

- Once connected, you should see Tables created as below.

![](RackMultipart20230112-1-xzd6k_html_820b0042be4d08d.png)

![](RackMultipart20230112-1-xzd6k_html_4e4da3d0ea20590c.png)

9.Install Postman for API testing

[https://www.postman.com/downloads/](https://www.postman.com/downloads/)

10.Create a folder on C: drive for your php projects. Name it whatever you like to call it

11.Open Windows Terminal (The program downloaded at step 4)

Type "git clone [https://github.com/tgmt/banktpmm.git](https://github.com/tgmt/banktpmm.git)"

12.Open new Terminal, "cd" to "banktpmm" folder

- composer install

- npm install

13.Open the folder in VSCode (The program downloaded at step 5)

- Go to .env file and .env.local
- Set the MySQL password

14.Open a new terminal and route to **//\<project\_folder\> (e.g banktpmm)**

- Run "php artisan migrate" (create MySQL tables)
- Run "php artisan serve" to launch php server
- Run "npm run dev" to launch Vite (do in a new terminal)

15.Go to [http://localhost:8080/](http://localhost:8080/)

The website should launch but will be empty contents

16.Copy these files to **//\<project\_folder\>/storage/app/public**
[https://drive.google.com/drive/folders/1z5ChtcJP-0-JCUNA7uHSskwDUB1HjVO2?usp=sharing](https://drive.google.com/drive/folders/1z5ChtcJP-0-JCUNA7uHSskwDUB1HjVO2?usp=sharing)

![](RackMultipart20230112-1-xzd6k_html_9893a3d29c583444.png)

17.Go to

[http://localhost:8080/setup/1](http://localhost:8080/setup/1)

[http://localhost:8080/setup/2](http://localhost:8080/setup/2)

[http://localhost:8080/setup/3](http://localhost:8080/setup/3)

[http://localhost:8080/setup/4](http://localhost:8080/setup/4)

[http://localhost:8080/setup/5](http://localhost:8080/setup/5)

The articles should be loaded into DynamoDB

18.Go to [http://localhost:8080/setuppages](http://localhost:8080/setuppages)

The pages should be loaded into DynamoDB

~ Now the setup is complete ~