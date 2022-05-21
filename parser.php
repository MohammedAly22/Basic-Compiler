<?php
    require 'grammerStacks.php';
    
    // parser function
    function parser(){
        $classStack = new Stack(); 
        $classStack->push("@");
        $classStack->push("Type");
        $classStack->push("Id");
        $classStack->push("{");
        
        $varStack = new Stack(); 
        $varStack->push("Type");
        $varStack->push("Id");
        $varStack->push(";");
                    
        $parserLines = [];
        $code = $_REQUEST['codeEditor'];
        $codeLines = str_replace("\n", "<br />", $code);
        $newCodeLines = explode("<br />", $codeLines);

        // generate parser Lines
        for($i = 0 ; $i < count($newCodeLines) ; $i++){
            $line = $newCodeLines[$i];
            $lineNumber = $i + 1;
            $tokensList = [];
            $token = "";

            // Generate Tokens List
            for($j = 0 ; $j < strlen($line) ; $j++){
                if($line[$j] == " " || $j == strlen($line)-1){
                    array_push($tokensList, $token);
                    $token = "";
                }else{
                    $token = substr_replace($token, $line[$j], strlen($token), 0);
                }
            }    
            array_push($parserLines, $tokensList);
        }

        for($i = 0 ; $i < count($parserLines) ; $i++){
            $lineNumber = $i + 1;
            $tokenStack = new Stack();
            $line = $parserLines[$i];

            // generate tokens Stack
            for($j = 0 ; $j < count($line) ; $j++){
                $myToken = $line[$j];
                $tokenStack->push($myToken);
            }
    
            $isValidClassDeclaration = checkMathcingClassDeclaration($classStack, $tokenStack);
            $isValidVariableDeclaration = checkMathcingVariableDeclaration($varStack, $tokenStack);

            if($isValidClassDeclaration){
                $output = "Line " . $lineNumber . ": <span class='token'>Matched</span>" . " --> Rule: <span class='tokenName'>Program and class declaration</span><br>";
                echo $output;
                continue;
            }
            elseif($isValidVariableDeclaration){
                $output = "Line " . $lineNumber . ": <span class='token'>Matched</span>" . " --> Rule: <span class='tokenName'>Variable declaration</span><br>";
                echo $output;
            }
            else{
                $output = "Line " . $lineNumber . ": <span class='error'>Not Matched</span><br>";
                echo $output;
            }
        }
    }

    // check if line is class declaration or not
    function checkMathcingClassDeclaration($classStack, $myStack){
        $tempReverse = new Stack();
        $tempReverse = copyStacks($myStack, $tempReverse);
        
        $tempClassStack = new Stack();
        $tempClassStack = copyStacks($classStack, $tempClassStack);

        $poppedNumber = 0;
        $isValid = false;

        while(!($tempReverse->emptyStack())){
            $poppedNumber += 1;
            $currentToken = $tempReverse->pop();
            $comparedToken = $tempClassStack->pop();

            if($currentToken == '' || $currentToken == ' '){
                continue;
            }
            
            if($poppedNumber == 2){
                $isValid = true;
                continue;
            }
            if($currentToken == $comparedToken){
                $isvalid = true;
            }
            else{
                $isvalid = false;
                return false;
            }
        }

        if($isValid && $tempClassStack->emptyStack()){
            return true;
        }
        else{
            return false;
        }   
    }

    // check if line is class declaration or not
    function checkMathcingVariableDeclaration($varStack, $myStack){
        $tempReverse = new Stack();
        $tempReverse = copyStacks($myStack, $tempReverse);

        $tempVarStack = new Stack();
        $tempVarStack = copyStacks($varStack, $tempVarStack);
    
        $poppedNumber = 0;
        $isValid = false;

        while(!($tempReverse->emptyStack())){
            $poppedNumber += 1;
            $currentToken = $tempReverse->pop();
            $comparedToken = $tempVarStack->pop();

            if($currentToken == '' || $currentToken == ' '){
                continue;
            }
            
            if($poppedNumber == 2){
                $isValid = true;
                continue;
            }
            if($poppedNumber == 3){
                $isValid = true;
                continue;
            }

            if($currentToken == $comparedToken){
                $isvalid = true;
            }
            else{
                $isvalid = false;
                return false;
            }
        }

        if($isValid && $tempVarStack->emptyStack()){
            return true;
        }
        else{
            return false;
        }   
    }


    // copy stack function
    function copyStacks($referenceStack, $copiedStack){
        $temp = new Stack();

        while(!$referenceStack->emptyStack()){
            $popped = $referenceStack->pop();
            $copiedStack->push($popped);
            $temp->push($popped);
        }

        // reverse copied stack
        $tempReverse = new Stack();
        while(!$copiedStack->emptyStack()){
            $popped = $copiedStack->pop();
            $tempReverse->push($popped);
        }

        // reverse temp
        while(!$temp->emptyStack()){
            $popped = $temp->pop();
            $referenceStack->push($popped);
        }

        return $tempReverse;
    }


    // check if we pressed on scanBtn call parser function
    if(isset($_POST["parseBtn"])){
        parser();
    }
?>