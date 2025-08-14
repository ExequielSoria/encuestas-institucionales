<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">




    <title>Iniciar Sesión</title>
</head>
<body>


<style>
    
    *{font-family: Nunito;}

    body{
        background-image: linear-gradient(rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.8)), url('https://img.freepik.com/free-vector/vector-polka-background-with-small-dots_1017-13972.jpg?semt=ais_hybrid&w=740&q=80');


        background-repeat: repeat;
        background-size: 25% auto ;

        text-align: center;
    }

   .container{
    background-color: #ffffffff;
    margin: 0 auto;
    padding:50px 20px 50px 20px;
    width: 1000px;
    border: 5px solid #1C1C1C;
    border-radius: 50px;

    box-shadow: 15px 15px 0px #1C1C1C;
   }


   .normal-text{

    color:#1C1C1C;
    width: 305px;
    font-size:25px;
    font-weight:bold;
   }

   
   .input{
        font-weight:bold;
        color:#1C1C1C;
        font-size:25px;
        height:72px;
        width: 600px;
        padding-left:20px;
        border: 5px solid #1C1C1C;
        border-radius: 50px;

   }

   .form-group{
        margin-bottom:30px;
        display: flex;
        justify-content:left;
   }

   .title{
        font-size: 30px;
        font-weight: bold;
        color: #1C1C1C;
   }

    .title-container {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 20px;
        margin-bottom:20px;
    }

    .title-container::before,
    .title-container::after {
        content: '';
        flex: 1;
        max-width: 150px;            /* controla el largo de la línea */
        border-bottom: 5px solid #1C1C1C; /* grosor y color */
        border-radius: 50px;          /* puntas redondeadas */
    }

    .title-container::before {
        margin-right: 12px;          /* espacio con el texto */
    }

    .title-container::after {
        margin-left: 12px;
    }

    .title-container span {
        font-weight: bold;
        font-family: 'Nunito', sans-serif; /* ya con tu fuente */
    }

    .button{
        background-color: #1C1C1C;
        color: #ffffff;
        font-size: 25px;
        font-weight: bold;
        width: 200px;
        height: 60px;
        border-radius: 50px;
        border: none;
        cursor: pointer;
    }


</style>
   
<div class="title-container">
    <p class="title" >Iniciar Sesión</p>
</div>


<form method="POST" action="?controller=users&action=login" class="container">

    <div class="form-group">
        <p class="normal-text">Usuario/Legajo</p>
        <input class ="input"type="text" name="username" placeholder="Juan Domingo"><br>
    </div>

    <div class="form-group">
        <p class="normal-text">Contraseña</p>
        <input class="input" type="password" name="password" placeholder="Contraseña"><br>
    </div>


    Creador/Administrador<input type="checkbox" name="isCreator"><br>
    <button type="submit" class="button">Ingresar</button>
</form>

</body>
</html>

<?php
