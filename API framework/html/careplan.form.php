<?php namespace _;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Homecare Patient Care Plan</title>
    <!--<link rel="stylesheet" type="text/css" href="/careplan.css" />-->
    <link href='https://fonts.googleapis.com/css?family=Nunito Sans' rel='stylesheet'>
    <style>
    
    body {
  font-family: 'Nunito Sans';
  font-size: 24px;
  line-height: 20px;
  font-weight: 400;
  color: #3b3b3b;
  -webkit-font-smoothing: antialiased;
  font-smoothing: antialiased;
  background: #e4e4e4;
        
    }
    
    table {

    width: 100%;
    border-collapse: separate;
    border-spacing: 0 4px;
    }
    
    tr {
    
    text-align: center;
    display: inline-block;
    background-color: #ffffff;
    color:#fff;
    
    margin: 2px;
    border: 1px black solid;
    border-radius: 8px;
    padding:10px 14px;
    border-collapse: separate;
    
    }

  th {
     border-right: 0.5px White solid;
      text-align: center;
      padding:0px 37.5px;
      background-color: #898da3;
      color:#fff;
      font-size:14px;
      
    }

     td {
     border-right: 0.5px black solid;
      text-align: center;
      padding: 0px 18px;
      background-color: #ffffff;
      color:black;
      font-size:14px;
      display: inline-block;

      
    }
    
    input[type=date]{
        background-color: white;
      color: black;
      font-size: 14px;
      width: 100px;
    border: 1px black solid;
    border-radius: 4px;
    }
    
    .presbtn{
    color: black;
    font-size: 14px;
    width: 80px;
    border: 1px black solid;
    border-radius: 4px;
    }
    .solid {
    border: 1px black solid;
    border-radius: 8px;
    background-color: #898da3;
    width: auto;
    
    
    }
    .solidrow {
    border: 1px black solid;
    border-radius: 8px;
    background-color: #ffffff;
    width: auto;
        
    }   
    
   /* tr:hover {
      background-color: #ededed;
      cursor: pointer;
    }
    .content td{
        border-top: 1px solid transparent;
        padding: 2px 10px 2px 15px;
    }
    
    .content th {
        border-top: 1px solid transparent;
        padding: 2px 10px 2px 15px;
        
    }
    
    */


    .btnp {
      background-color: #7be4f7;
      color: black;
      font-size: 14px;
      border: none;
      outline: none;
      border-radius: 2px;
      
    }
    
    
    .btns {
      background-color: #7be4f7;
      color: black;
      font-size: 14px;
      border: none;
      outline: none;
      border-radius: 2px;
      
    }

    .dropdownshift {
      background-color: #7be4f7;
      color: black;
      font-size: 14px;
      border: none;
      outline: none;
      border-radius: 2px;
    }    
    
    .btninline {
      position: none;
      display: inline;
    }
    
    .btninlineblock {
      position: none;
      display: inline-block;
    }
    
    .btnp:hover {
      background-color: Red;
    
    }
    
    .btns:hover {
      background-color: Yellow;
    }

        
    </style>
    
<script>

    function addSGB11caremodule(){

        var table = document.getElementById("SGB11Table");
        
        var x = document.getElementById("SGB11Table").rows.length;
        
        // Create an empty <tr> element and add it to the 1st position of the table:
        var row = table.insertRow(1);
        
        // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
        var cell0 = row.insertCell(0);
        var cell1 = row.insertCell(1);
        var cell2 = row.insertCell(2);
        var cell3 = row.insertCell(3);
        var cell4 = row.insertCell(4);
        var cell5 = row.insertCell(5);
        var cell6 = row.insertCell(6);
        var cell7 = row.insertCell(7);
        var cell8 = row.insertCell(8);
        var cell9 = row.insertCell(9);
        var cell10 = row.insertCell(10);
        
        
        // Add some text to the new cells:
        cell0.innerHTML = "CM0003";
        cell1.innerHTML = "Partial Bathing";
        cell2.innerHTML = "12:00";
        cell3.innerHTML = "SA01";
        cell4.innerHTML = "SA01";
        cell5.innerHTML = "SA01";
        cell6.innerHTML = "SA01";
        cell7.innerHTML = "SA01";
        cell8.innerHTML = "SA01";
        cell9.innerHTML = "SA01";
        cell10.innerHTML = "SA01";
    }


    function addSGB5caremodule(){

        var table = document.getElementById("SGB5Table");
        
        var x = document.getElementById("SGB5Table").rows.length;
        
        // Create an empty <tr> element and add it to the 1st position of the table:
        var row = table.insertRow(1);
        
        // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
        var cell0 = row.insertCell(0);
        var cell1 = row.insertCell(1);
        var cell2 = row.insertCell(2);
        var cell3 = row.insertCell(3);
        var cell4 = row.insertCell(4);
        var cell5 = row.insertCell(5);
        var cell6 = row.insertCell(6);
        var cell7 = row.insertCell(7);
        var cell8 = row.insertCell(8);
        var cell9 = row.insertCell(9);
        var cell10 = row.insertCell(10);
        
        
        // Add some text to the new cells:
        cell0.innerHTML = "CM0003";
        cell1.innerHTML = "Partial Bathing";
        cell2.innerHTML = "12:00";
        cell3.innerHTML = "SA01";
        cell4.innerHTML = "SA01";
        cell5.innerHTML = "SA01";
        cell6.innerHTML = "SA01";
        cell7.innerHTML = "SA01";
        cell8.innerHTML = "SA01";
        cell9.innerHTML = "SA01";
        cell10.innerHTML = "SA01";
    }

    function internalcaremodule(){

        var table = document.getElementById("internalTable");
        
        var x = document.getElementById("internalTable").rows.length;
        
        // Create an empty <tr> element and add it to the 1st position of the table:
        var row = table.insertRow(1);
        
        // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
        var cell0 = row.insertCell(0);
        var cell1 = row.insertCell(1);
        var cell2 = row.insertCell(2);
        var cell3 = row.insertCell(3);
        var cell4 = row.insertCell(4);
        var cell5 = row.insertCell(5);
        var cell6 = row.insertCell(6);
        var cell7 = row.insertCell(7);
        var cell8 = row.insertCell(8);
        var cell9 = row.insertCell(9);
        var cell10 = row.insertCell(10);
        
        
        // Add some text to the new cells:
        cell0.innerHTML = "CM0003";
        cell1.innerHTML = "Partial Bathing";
        cell2.innerHTML = "12:00";
        cell3.innerHTML = "SA01";
        cell4.innerHTML = "SA01";
        cell5.innerHTML = "SA01";
        cell6.innerHTML = "SA01";
        cell7.innerHTML = "SA01";
        cell8.innerHTML = "SA01";
        cell9.innerHTML = "SA01";
        cell10.innerHTML = "SA01";
    }



</script>
    
    
</head>

<body>
	<header>
    	<h2>Patient Care Plan</h2>
	</header>


<form id="CarePlanForm">

<table id="SGB11Table">
        <tr class="solid">
            <th>SGB 11</th>
            <th>Name&nbsp;&nbsp;&nbsp;<img src='html/add.square.rounded.icon.white.png' width="16" height="16"  onclick="addSGB11caremodule()"></th>
            <th>Prescription</th>
            <th>Expiry</th>
            <th>mm:ss</th>
            <th>Shift</th>
            <th>Mon</th>
            <th>Tue</th>
            <th>Wed</th>
            <th>Thu</th>
            <th>Fri</th>
            <th>Sat</th>
            <th>Sun</th>
        </tr>

<tbody >


<tr class="solidrow">
    <td>CM0003</td>
    <td>Partial Bathing</td>
    <td><button class="presbtn" onclick="alert('Hello world!')">Upload</button></td>
    <td><input type="date" id="expiry" name="expiry"></td>
    <td>12:00</td>
    
    <td><div><select class="dropdownshift" name="shifts" id="shifts">
    <option value="sa01" selected>SA01</option>
    <option value="sa02">SA02</option>
    <option value="sa03">SA03</option>
    <option value="sa04">SA04</option>
    </select></div>
    <div><select class="dropdownshift" name="shifts" id="shifts">
    <option value="sa01">SA01</option>
    <option value="sa02"selected>SA02</option>
    <option value="sa03">SA03</option>
    <option value="sa04">SA04</option>
    </select></div>
    <div><select class="dropdownshift" name="shifts" id="shifts">
    <option value="sa01">SA01</option>
    <option value="sa02">SA02</option>
    <option value="sa03"selected>SA03</option>
    <option value="sa04">SA04</option>
    </select></div>        
    <div><select class="dropdownshift" name="shifts" id="shifts">
    <option value="sa01">SA01</option>
    <option value="sa02">SA02</option>
    <option value="sa03">SA03</option>
    <option value="sa04"selected>SA04</option>
    </select></div>        
    </td>
    
    <td><div><button class="btnp">P<button class="btns">SA01</button></button></div>
    <div><button class="btnp">P</button><button class="btns">SA02</button></div>
    <div><button class="btnp">P</button><button class="btns">SA03</button></div>
    <div><button class="btnp">P</button><button class="btns">SA04</button></div></td>

    <td><div><button class="btnp">P</button><button class="btns">SA01</button></div>
    <div><button class="btnp">P</button><button class="btns">SA02</button></div>
    <div><button class="btnp">P</button><button class="btns">SA03</button></div>
    <div><button class="btnp">P</button><button class="btns">SA04</button></div></td>

    <td><div><button class="btnp">P</button><button class="btns">SA01</button></div>
    <div><button class="btnp">P</button><button class="btns">SA02</button></div>
    <div><button class="btnp">P</button><button class="btns">SA03</button></div>
    <div><button class="btnp">P</button><button class="btns">SA04</button></div></td>

    <td><div><button class="btnp">P</button><button class="btns">SA01</button></div>
    <div><button class="btnp">P</button><button class="btns">SA02</button></div>
    <div><button class="btnp">P</button><button class="btns">SA03</button></div>
    <div><button class="btnp">P</button><button class="btns">SA04</button></div></td>

    <td><div><button class="btnp">P</button><button class="btns">SA01</button></div>
    <div><button class="btnp">P</button><button class="btns">SA02</button></div>
    <div><button class="btnp">P</button><button class="btns">SA03</button></div>
    <div><button class="btnp">P</button><button class="btns">SA04</button></div></td>

    <td><div><button class="btnp">P</button><button class="btns">SA01</button></div>
    <div><button class="btnp">P</button><button class="btns">SA02</button></div>
    <div><button class="btnp">P</button><button class="btns">SA03</button></div>
    <div><button class="btnp">P</button><button class="btns">SA04</button></div></td>

    <td><div><button class="btnp">P</button><button class="btns">SA01</button></div>
    <div><button class="btnp">P</button><button class="btns">SA02</button></div>
    <div><button class="btnp">P</button><button class="btns">SA03</button></div>
    <div><button class="btnp">P</button><button class="btns">SA04</button></div></td>
</tr>


</tbody>
</table>


<table id="SGB5Table">
        <tr class="solid">
            <th>SGB 05</th>
            <th>Name&nbsp;&nbsp;&nbsp;<img src='html/add.square.rounded.icon.white.png' width="16" height="16"  onclick="addSGB5caremodule()"></th>
            <th>Prescription</th>
            <th>Expiry</th>
            <th>mm:ss</th>
            <th>Shift</th>
            <th>Mon</th>
            <th>Tue</th>
            <th>Wed</th>
            <th>Thu</th>
            <th>Fri</th>
            <th>Sat</th>
            <th>Sun</th>
        </tr>


<tbody>

<tr class="solidrow">
    <td>VM0011</td>
    <td>Partial Bathing</td>
    <td><button class="presbtn" onclick="alert('Hello world!')">Upload</button></td>
    <td><input type="date" id="expiry" name="expiry"></td>
    <td>10:00</td>
    
    <td><div><select class="dropdownshift" name="shifts" id="shifts">
    <option value="sa01" selected>SA01</option>
    <option value="sa02">SA02</option>
    <option value="sa03">SA03</option>
    <option value="sa04">SA04</option>
    </select></div>
    <div><select class="dropdownshift" name="shifts" id="shifts">
    <option value="sa01">SA01</option>
    <option value="sa02"selected>SA02</option>
    <option value="sa03">SA03</option>
    <option value="sa04">SA04</option>
    </select></div>
    <div><select class="dropdownshift" name="shifts" id="shifts">
    <option value="sa01">SA01</option>
    <option value="sa02">SA02</option>
    <option value="sa03"selected>SA03</option>
    <option value="sa04">SA04</option>
    </select></div></td>
    
    <td><div><button class="btnp">P</button><button class="btns">SA01</button></div>
    <div><button class="btnp">P</button><button class="btns">SA02</button></div>
    <div><button class="btnp">P</button><button class="btns">SA03</button></div></td>

    <td><div><button class="btnp">P</button><button class="btns">SA01</button></div>
    <div><button class="btnp">P</button><button class="btns">SA02</button></div>
    <div><button class="btnp">P</button><button class="btns">SA03</button></div></td>

    <td><div><button class="btnp">P</button><button class="btns">SA01</button></div>
    <div><button class="btnp">P</button><button class="btns">SA02</button></div>
    <div><button class="btnp">P</button><button class="btns">SA03</button></div></td>

    <td><div><button class="btnp">P</button><button class="btns">SA01</button></div>
    <div><button class="btnp">P</button><button class="btns">SA02</button></div>
    <div><button class="btnp">P</button><button class="btns">SA03</button></div></td>

    <td><div><button class="btnp">P</button><button class="btns">SA01</button></div>
    <div><button class="btnp">P</button><button class="btns">SA02</button></div>
    <div><button class="btnp">P</button><button class="btns">SA03</button></div></td>

    <td><div><button class="btnp">P</button><button class="btns">SA01</button></div>
    <div><button class="btnp">P</button><button class="btns">SA02</button></div>
    <div><button class="btnp">P</button><button class="btns">SA03</button></div></td>

    <td><div><button class="btnp">P</button><button class="btns">SA01</button></div>
    <div><button class="btnp">P</button><button class="btns">SA02</button></div>
    <div><button class="btnp">P</button><button class="btns">SA03</button></div></td>
</tr>




</tbody>
</table>



<table id="internalTable">
        <tr class="solid">
            <th>Internal</th>
            <th>Name&nbsp;&nbsp;&nbsp;<img src='html/add.square.rounded.icon.white.png' width="16" height="16"  onclick="internalcaremodule()"></th>
            <th>Prescription</th>
            <th>Expiry</th>
            <th>mm:ss</th>
            <th>Shift</th>
            <th>Mon</th>
            <th>Tue</th>
            <th>Wed</th>
            <th>Thu</th>
            <th>Fri</th>
            <th>Sat</th>
            <th>Sun</th>
        </tr>

<tbody>

</tbody>
</table>


</form>

</body>

</html>
