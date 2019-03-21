# Shopping-Cart-
I try to do simple shopping cart appliciation.

# Notes :

I usually use PDO for safety connection between MySQL database and my php files. But in this project i used the old version of connection type.
And that type is mysqli connection.

## Connect.php ##
As you can see, i use 'try and catch blocks' for make database connection safetly. And generally i use PDO, i 've told this already.
And if i want to convert this mysqli connection to PDO it should be like that: 

<b> try {<br>
    $connect = new PDO("mysql:localhost=host;dbname="test";charset=utf8", 'root', '');<br>
  } <br><br>
  catch(PDOEXCEPTION $e) { <br>
  echo $e->getMessage(); <br>
  }<br>
  </b>
  
![Adsız](https://user-images.githubusercontent.com/43685404/54750344-61fd5900-4be8-11e9-9857-6d232379d3ad.png)

## Shopping.php ## 
I made all other stuff except database in here. I've just got include 'connect.php' to my page.
