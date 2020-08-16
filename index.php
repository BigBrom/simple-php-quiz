<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple quiz</title>
</head>

<?php


    $cnt = $_COOKIE['cnt'] ?? 0;
    $questions = [
        0 => [
            'question' => 'SEO Stand for...',
            'ansvers' => [
                '1' => 'Secret Enterprise Organizations',
                '2' => 'Special Endowment Opportunity',
                '3' => 'Search Engine Optimization',
                '4' => 'None of the above',
                '5' => 'Seals End Olives'
            ],
            'correct' => '3'
        ],
        1 => [
            'question' => 'CSS Stands for...',
            'ansvers' => [
                'A' => 'Computer Styled Sections',
                'B' => 'Cascading Style Sheets',
                'C' => 'Crazy Solid Shapes',
                'D' => 'None of the above',
                'E' => 'Hyper text language'
            ],
            'correct' => 'B'
        ],
        2 => [
            'question' => 'Internet Explorer 6 was released in...',
            'ansvers' => [
                'A' => '2001',
                'B' => '1998',
                'C' => '2006',
                'D' => '2003',
            ],
            'correct' => 'B'
        ],
        3 => [
            'question' => 'A 404 Error...',
            'ansvers' => [
                'A' => 'is an HTTP Status Code meaning Page Not Found',
                'B' => 'is a good excuse for a clever design',
                'C' => 'should be monitored for in web analytics',
                'D' => 'All of the above',
            ],
            'correct' => ['A', 'B']
        ],
    ];
    $ansver = !empty($_POST['ansver']) ? $_POST['ansver'] : '';
    $sended = false;
    if($ansver) {
        setcookie($cnt, json_encode($ansver));
        $cnt++;
        setcookie('cnt', $cnt);

    }
    $phone = !empty($_POST['tel']) ? $_POST['tel'] : '';
    $mail = !empty($_POST['email']) ? $_POST['email'] : '';
    if($phone && $mail) {
        $correctAnsvers = '';
        for ($i=0; $i < count($questions); $i++) { 
            $data = json_decode($_COOKIE[$i]);
            
            if(is_array($data)) {
                foreach ($data as $value) {
                    if(in_array($value, $questions[$i]['correct'])) {                   
                        $a = $questions[$i]['ansvers'][$value];
                        $correctAnsvers .= $a .'\n';
                    }
                }
            }else {
                if($questions[$i]['correct'] === $data) {
                    $a = $questions[$i]['ansvers'][$data];
                    $correctAnsvers .= $a .'\n';
                }
            }
      
        }
        
        if(mail($mail, "Result quiz", $correctAnsvers)) $sended = true; 
    }
    
?>

<style>
    label, button {display: block; margin-top: 15px}
</style>    
<body>
    <h1>Simple quiz</h1>

    <?if($cnt < count($questions)):?>
        <b>Question <?=($cnt + 1)?> of <?=count($questions)?>:</b>
        <h2><?=$questions[$cnt]['question']?></h2>
        <form method="post">
            <?foreach($questions[$cnt]['ansvers'] as $key => $value):?>
                <label>
                    <?if(is_array($questions[$cnt]['correct'])):?>
                        <input type="checkbox" name="ansver[]" value="<?=$key?>">
                    <?else:?>
                        <input type="radio" name="ansver" value="<?=$key?>">
                    <?endif?>
                    <b><?=$value?></b>
                </label>
            <?endforeach?>
            <button type="submit">Send</button>
        </form>
    <?else:?>
        <?if($sended):?>
            <h2>Ansvers sended on your email</h2>
        <?else:?> 
            <h2>leave your contacts and we will send the result to you by mail</h2>
            <form method="post">
                <input type="tel" placeholder="you phone" name="tel" require>
                <input type="email" placeholder="you email" name="email"require>
                <button type="submit">submit</button>
            </form> 
        <?endif?>    
    <?endif?>

</body>
</html>