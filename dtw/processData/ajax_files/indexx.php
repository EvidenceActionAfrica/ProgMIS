<html>
  <head>
    <script>
      function showUser(str)  {
        if (str == "")  {
          document.getElementById("txtHint").innerHTML = "";
          return;
        }
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()  {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
          }
        }
        xmlhttp.open("GET", "getuser.php?q=" + str, true);
        xmlhttp.send();
      }
      
      //show all users
      function showAllRecords(limit)  {
        if (limit == "")  {
          document.getElementById("divShowContent").innerHTML = "";
          return;
        }
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()  {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("divShowContent").innerHTML = xmlhttp.responseText;
          }
        }
        xmlhttp.open("GET", "getuser.php?limit=" + limit, true);
        xmlhttp.send();
      }
    </script>
  </head>
  <body>

    <form>
      <select name="users" onchange="showUser(this.value)">
        <option value="24">Peter Griffin</option>
        <option value="27">Lois Griffin</option>
        <option value="28">Lois Griffin</option>
      </select>
    </form>
    <br>
    <div id="txtHint"><b>Person info will be listed here.</b></div>
    
    <a href="#" onclick="showAllRecords(4);"> show all records</a>
    <div id="divShowContent"><b>Person info will be listed here.</b></div>
    
  </body>
</html> 