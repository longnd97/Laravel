<?php


namespace App\Http\Controllers;



use Illuminate\Http\Request;

interface UserInterface
{
    function getPostOfUser($idUser);
}
