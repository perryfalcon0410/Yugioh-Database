<?php

function inputElement($icon,$placeholder,$name,$value){
    $ele="

    <div class=\"input-group mb-2\">
        <div class=\"input-group-prepend\">
            <div class=\"input-group-text\">$icon</div>
        </div>
        <input type=\"text\" name='$name'value='$value' autocomplete=\"off\" class=\"form-control\"id=\"inlineFormInputGroup\"placeholder='$placeholder'>
    </div>
    ";
    echo $ele;
}

function buttonElement($btnid, $styleclass, $text, $name, $attr){
    $btn = "
    <button name='$name' '$attr' class='$styleclass' id='$btnid' style='padding: 10px 10px, margin: 10px 10px'>$text</button>
    ";
    echo $btn;
}