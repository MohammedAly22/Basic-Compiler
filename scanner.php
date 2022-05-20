<?php
// scanner function
function scanner(){
    // keywords array
    global $keywords;
    $keywords = array(
        "Type",
        "Print",
        "Infer",
        "If",
        "Else",
        "Ipok",
        "Sipok",
        "Craf",
        "Sequence",
        "Ipokf",
        "Sipokf",
        "Valueless",
        "Rational",
        "Endthis",
        "However",
        "When",
        "RespondWith",
        "Srap",
        "Scan",
        "Require",
        "@",
        "^",
        "$",
        "#",
        "=",
        "+",
        "-",
        "*",
        "/",
        "&&",
        "||",
        "~",
        "==",
        "<",
        ">",
        "!=",
        "<=",
        ">=",
        "->",
        "{",
        "}",
        "[",
        "]",
        "(",
        ")",
        '"',
        "'",
        "0",
        "1",
        "2",
        "3",
        "4",
        "5",
        "6",
        "7",
        "8",
        "9",
        "</",
        "/>",
        ";"
    );

    // Dictionary array for matching keywords with their values
    $dictionary = array(
        "Type" => "Class",
        "Print" => "Display",
        "Infer" => "Inheritance",
        "If" => "Condition",
        "Else" => "Condition",
        "Ipok" => "Integer",
        "Sipok" => "Signed Integer",
        "Craf" => "Character",
        "Sequence" => "String",
        "Ipokf" => "Float",
        "Sipokf" => "Signed Float",
        "Valueless" => "Void",
        "Rational" => "Boolean",
        "Endthis" => "Break",
        "However" => "Loop",
        "When" => "Loop",
        "RespondWith" => "Return",
        "Srap" => "Struct",
        "Scan-ConditionOf" => "Switch",
        "Require" => "Inclusion",
        "@" => "Start Symbol",
        "^" => "Start Symbol",
        "$" => "End Symbol",
        "#" => "End Symbol",
        "=" => "Assignment Operation",
        "+" => "Arithmetic Operation(Add)",
        "-" => "Arithmetic Operation(Subtract)",
        "*" => "Arithmetic Operation(Multiply)",
        "/" => "Arithmetic Operation(Division)",
        "&&" => "Logical Operator(And)",
        "||" => "Logical Operator(Or)",
        "~" => "Logical Operator(Not)",
        "==" => "Relational Operator(Is Equal)",
        "<" => "Relational Operator(Less Than)",
        ">" => "Relational Operator(Greater Than)",
        "!=" => "Relational Operator(Not Equal)",
        "<=" => "Relational Operator(Less Than Or Equal)",
        ">=" => "Relational Operator(Greater Than Or Equal)",
        "->" => "Access operator",
        "{" => "Left Brace",
        "}" => "Right Brace",
        "[" => "Left Square Bracket",
        "]" => "Right Square Bracket",
        "(" => "Left Parentheses",
        ")" => "Right Parentheses",
        '"' => "Quotation Mark",
        "'" => "Quotation Mark",
        "0" => "Constant",
        "1" => "Constant",
        "2" => "Constant",
        "3" => "Constant",
        "4" => "Constant",
        "5" => "Constant",
        "6" => "Constant",
        "7" => "Constant",
        "8" => "Constant",
        "9" => "Constant",
        "***" => "Single Line Comment",
        "</" => "Multiple Line Comment Open",
        "/>" => "Multiple Line Comment Close",
        ";" => "End Of Statement"
    );

    // read code from textarea
    $code = $_REQUEST['codeEditor'];
    $codeLines = str_replace("\n", "<br />", $code);
    $newCodeLines = explode("<br />", $codeLines);
    
    $errorCount = 0;
    global $identifiersList;
    $identifiersList = [];

    // iterating on code line by line
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
        
        // Iterating on tokensList at each line after generating it
        for($k = 0 ; $k < count($tokensList) ; $k++){
            $myToken = $tokensList[$k];     
            $flag = false;
            $preToken = "";

            if($myToken == "***"){
                $output = "Line " . $lineNumber . ": <span class='tokenName'>Comment</span><br>";
                echo $output;
                break;
            }

            if($k != 0){
                $preToken = $tokensList[$k-1];
            }
            if($myToken == ""){
                continue;
            }

            // check if the current token in keywords array
            foreach($keywords as $keyword){
                if($flag == false)
                    if($keyword == $myToken)
                        $flag = true;
            }

            // key word Founded in keyWords Dictionary
            if($flag == true){
                $koko = array("Type", "Ipok", "Sipok", "Craf", "Sequence", "Ipokf", "Sipokf", "Valueless", "Rational");
                $isDataType = false;
                foreach($koko as $type){
                    if($isDataType == false){
                        if($preToken == $type){
                            $isDataType = true;
                        }
                    }
                }
                if($isDataType == false){
                    $output = "Line " . $lineNumber . ": Token Text: " . "<span class='tokenName'>" . $myToken . "</span>" . ", Token Type: " . "<span class='token'>" . $dictionary[$myToken] . "</span>" . "<br>";
                    echo $output;
                }
                else{
                    $errorCount += 1;
                    $output = "<span class='error'>Line " . $lineNumber . ": Cannot Declare a Variable with a reserved keyword: " . $myToken . "</span><br>";
                    echo $output;
                }  
            }
            else{
                // check if myToken is valid identifier
                if(isValidIdentifier($preToken, $myToken) ){
                    $output = "Line " . $lineNumber . ": Token Text: " . "<span class='tokenName'>" . $myToken . "</span>" . ", Token Type: " . "<span class='token'>Identifier</span>" . "<br>";
                    array_push($identifiersList, $myToken);
                    echo $output;
                }
                else{
                    // check if identifier is already declared
                    $isIdentifier = false;
                    foreach($identifiersList as $identifier){
                        if($isIdentifier == false){
                            if($identifier == $myToken){
                                $isIdentifier = true;
                            }
                        }
                    }
                    if($isIdentifier == true){
                        $output = "Line " . $lineNumber . ": Token Text: " . "<span class='tokenName'>" . $myToken . "</span>" . ", Token Type: " . "<span class='token'>Identifier</span>" . "<br>";
                        echo $output;
                    }
                    else{
                        if(isNumber($myToken)){
                            $output = "Line " . $lineNumber . ": Token Text: " . "<span class='tokenName'>" . $myToken . "</span>" . ", Token Type: " . "<span class='token'>Number</span>" . "<br>";
                            echo $output;
                        }
                        else{
                            $errorCount += 1;
                            $output = "<span class='error'>Line " . $lineNumber . ": Error in Token Text: " . $myToken . "</span><br>";
                            echo $output;
                        }
                    }  
                }    
            }
        }
        echo "<span class='lineColor'>----------------------------------------------------------------</span><br>";         
    }

    // Print Identifiers Table
    printIdentifiersTable($identifiersList);

    // displaying total number of errors
    if($errorCount == 0){
        $output = "<br><span class='token'>Congratulations, There Is No Errors: " . $errorCount . "</span><br>";
        echo $output;
    }
    else{
        $output = "<br><span class='error'>Total Number Of Errors: " . $errorCount . "</span><br>";
        echo $output;
    }
}   

// take an identifier and return if is it valid or not
function isValidIdentifier($dataType, $identifier){
    // data types list
    $dataTypes = array("Type", "Ipok", "Sipok", "Craf", "Sequence", "Ipokf", "Sipokf", "Valueless", "Rational");
    $found = false;

    // check if the data type exist in DataTypes list or not
    foreach($dataTypes as $type){
        if($found == false)
            if($type == $dataType)
                $found = true;
    }

    // check if any character (except the last one) is not a character or _ 
    for($i=0 ; $i < strlen($identifier)-1 ; $i++){
        if($identifier[$i] == '1' || $identifier[$i] == '2' || $identifier[$i] == '3' || $identifier[$i] == '4'
        || $identifier[$i] == '5' || $identifier[$i] == '6' || $identifier[$i] == '7' || $identifier[$i] == '8'
        || $identifier[$i] == '9' || $identifier[$i] == '0' || $identifier[$i] == '~' || $identifier[$i] == '!'
        || $identifier[$i] == '@' || $identifier[$i] == '#' || $identifier[$i] == '$' || $identifier[$i] == '%'
        || $identifier[$i] == '^' || $identifier[$i] == '&' || $identifier[$i] == '*' || $identifier[$i] == '('
        || $identifier[$i] == ')' || $identifier[$i] == '-' || $identifier[$i] == '+' || $identifier[$i] == '='
        || $identifier[$i] == '[' || $identifier[$i] == ']' || $identifier[$i] == '{' || $identifier[$i] == '}'
        || $identifier[$i] == '|' || $identifier[$i] == '"' || $identifier[$i] == "'" || $identifier[$i] == ';'
        || $identifier[$i] == ':' || $identifier[$i] == ',' || $identifier[$i] == '<' || $identifier[$i] == '.'
        || $identifier[$i] == '>' || $identifier[$i] == '/' || $identifier[$i] == '?'){
            return false;
        }
    }

    // get the last charcater of identifier name
    $lastCharcater = $identifier[-1];
    if($lastCharcater == '~' || $lastCharcater == '!' || $lastCharcater == '@' || $lastCharcater == '#' 
    || $lastCharcater == '$' || $lastCharcater == '%' || $lastCharcater == '^' || $lastCharcater == '&' 
    || $lastCharcater == '*' || $lastCharcater == '(' || $lastCharcater == ')' || $lastCharcater == '-' 
    || $lastCharcater == '+' || $lastCharcater == '=' || $lastCharcater == '[' || $lastCharcater == ']' 
    || $lastCharcater == '{' || $lastCharcater == '}' || $lastCharcater == '|' || $lastCharcater == '"'
    || $lastCharcater == "'" || $lastCharcater == ';' || $lastCharcater == ':' || $lastCharcater == ',' 
    || $lastCharcater == '<' || $lastCharcater == '.' || $lastCharcater == '>' || $lastCharcater == '/'
    || $lastCharcater == '?'){
        return false;
    }
    if($found == false){
        return false;
    }
    else{
        return true;
    }
}

// check if the current token is a number or not
function isNumber($number){
    if(is_numeric($number)){
        return true;
    }
    else{
        return false;
    }
}

// printing identifiers List function
function printIdentifiersTable($identifiersList){
    echo "<br><span class='token'>(Table Of Identifiers)</span><br>";
    for($i = 0 ; $i < count($identifiersList) ; $i++){
        $rowNumber = $i + 1;
        $identifierName = $identifiersList[$i];
        $output = $rowNumber . ".  Identifier Name: " . "<span class='tokenName'>" . $identifierName . "</span>" . "<br>";
        echo $output;
    }
}

if(isset($_POST["scanBtn"])){
    scanner();
}
?>