<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>萬年曆</title>
    <style>
        body {         
            background-image: url('image/bg-1.png');
            background-repeat: no-repeat;
            background-size: cover;
            height: 100vh;
        }

        table {
            width: 100%;
            max-width: 700px;
            border-collapse: collapse;
            margin: auto;
            background-color: #fff;
            opacity: 0.9;

        }
        td {
            padding: 5px 10px;
            text-align: center;
            border: 1px solid #999;
            width: 100PX;
            height: 60px;
        }
        .holidays {
            color:#851d17;
            margin: 0 0;
            font-size: 15px;
        }
        .grey-text {
            color: #999;
            background-color: #ba9b8d;
            border-radius: 5px;
        }
        /* 週末的背景色設為粉紅 */
        .weekend {
            background-color: #F4D6CC;
        }
        .today {
            background-color: #C83E4D;
            color: white;
            font-weight: bolder;
            animation: heart 2s .3s infinite ease;
        }
        @keyframes heart {
            0%{ color: #E8F7EE; font-size: 20px} 
            25%{ color: white; font-size: 15px}
            50%{ color: #E8F7EE; font-size: 20px} 
            75%{ color: white; font-size: 15px}
            100%{ color: #E8F7EE; font-size: 20px} 
        }
        .nav {
            width: 100%;
            margin: auto;
       
        }
        .nav table td {
            border: 0px;
            padding: 0;
            background-color: #4E937A;
        }
        a {
            text-decoration: none;
            background-color: #ba9b8d;
            padding: 5px;
            margin: 0 10px;
            border-radius: 10px;
            color: white;
            transition: 0.5s;
        }
        a:hover {
            background-color: #e4dfaf;
            color: #ba9b8d;
            font-size:20px ;
        }
        a:hover {
            color: orange;
        }
 
        .backToday{
            margin-top: 5vh;
        }
        td[class^='day']:hover {
            transition: .5s;
            background-color: #FF9152; 
            cursor: pointer; /* 滑鼠指標變為點擊手勢 */
            color: white;
            transform: translateY(-5px);
        }

        .week{
            color:lightblue;
        }
    </style>
</head>
<body>
<?php
// 取得當前的月份和年份，若沒有透過URL傳遞則使用當前月份和年份
$month = isset($_GET['month']) ? $_GET['month'] : date("m");

// $month = date('m');

// if($_GET['month']) {
//     $month = $_GET['month'];
// }

$year = isset($_GET['year']) ? $_GET['year'] : date("Y");

// $year = date("Y");

// if(isset($_GET['year'])){
//     $year = $_GET['year'];
// }


// 計算上一個月的年月
$prevMonth = $month - 1;
// $prevYear = $year;

if ($prevMonth < 1) {
    $prevMonth = 12; // 如果是1月，則上一個月是12月
    $prevYear = $year - 1; // 需將年份減少1
} else {
    $prevYear = $year;
}

// 計算下一個月的年月
$nextMonth = $month + 1;
// $nextYear = $year;

if ($nextMonth > 12) {
    $nextMonth = 1; // 如果是12月，則下一個月是1月
    $nextYear = $year + 1; // 需將年份增加1
} else {
    $nextYear = $year;
}

//計算前一年
$tprevYear = $year -1;

//計算後一年
$tnextYear = $year +1;


// 每年固定的假期
$holidays = [
    '01-01' => "元旦",
    '02-28' => "和平紀念日", 
    '04-04' => "兒童節",
    '04-05' => "清明節", 
    '10-10' => "國慶日", 
    '12-25' => "聖誕節",
];

// 計算當月的第一天是星期幾
$firstDay = "$year-$month-01"; // 取得當月的第一天
$firstDayTime = strtotime($firstDay); // 將第一天轉換為時間戳
$firstDayWeek = date("w", $firstDayTime); // 取得第一天是星期幾，0為星期日

// 取得當月有多少天
$daysInMonth = date("t", $firstDayTime);  // 當月的天數
?>
<div style="text-align:center;">
    <h1 style="color: white">萬年曆</h1>
</div>

<div class="nav">
    <table style="width:100%">
        <tr>
            <td style='text-align:left;'>
                <a href="index.php?year=<?= $tprevYear; ?>&month=<?= $month; ?>">前年</a>
                <a href="index.php?year=<?= $prevYear; ?>&month=<?= $prevMonth; ?>">上一個月</a>
            </td>
            <td style="color: white;">
                <?= $year; ?> 年 <?= $month; ?> 月
            </td>
            <td style='text-align:right'>
                <a href="index.php?year=<?= $nextYear; ?>&month=<?= $nextMonth; ?>">下一個月</a>
                <a href="index.php?year=<?= $tnextYear; ?>&month=<?= $month; ?>">明年</a>
            </td>
        </tr>
    </table>
</div>

<table>
        <tr>
            <td style="color: #A72608">日</td>
            <td style="color: #004F2D">一</td>
            <td style="color: #004F2D">二</td>
            <td style="color: #004F2D">三</td>
            <td style="color: #004F2D">四</td>
            <td style="color: #004F2D">五</td>
            <td style="color: #A72608">六</td>
        </tr>
<?php
// 計算顯示的天數
$daysShown = 0; // 記錄顯示的天數
for ($i = 0; $i < 6; $i++) { // 六行
    echo "<tr>";
    for ($j = 0; $j < 7; $j++) { // 七列（週日到週六）
        if ($daysShown < $firstDayWeek) {
            // 如果還沒到當月的第一天，則顯示空格
            echo "<td></td>";
        } elseif ($daysShown < $daysInMonth + $firstDayWeek) {
            // 顯示當月的日期
            $currentDay = $daysShown - $firstDayWeek; // 日期開始的偏移
            $theDayTime = strtotime("$currentDay days", $firstDayTime);
            $day = date("d", $theDayTime); // 取得日（1-31）
            $dateStr = date("Y-m-d", $theDayTime); // 格式化成 "YYYY-MM-DD" 格式

            // 判斷是否為本月日期
            $theMonthClass = (date("m", $theDayTime) == $month) ? '' : 'grey-text';
            // 判斷是否為今天的日期
            $isTodayClass = ($dateStr == date("Y-m-d")) ? 'today' : '';
            // 判斷是否為週末（週日和週六）
            $isWeekendClass = (date("w", $theDayTime) == 0 || date("w", $theDayTime) == 6) ? 'weekend' : '';

            echo "<td class='day $theMonthClass $isTodayClass $isWeekendClass'>$day"; // 顯示日期
            if (isset($spDate[$dateStr])) {
                echo "<br>{$spDate[$dateStr]}";
            }
            if (isset($holidays[date("m-d", $theDayTime)])) {
                echo "<br><p class='holidays'>{$holidays[date("m-d", $theDayTime)]}</p>";
            }
            echo "</td>";
        } else {
            // 如果超過了當月的日期，則顯示空格
            echo "<td></td>";
        }
        $daysShown++; // 更新顯示過的天數
    }
    echo "</tr>";
}
?>
</table>
    <div class="backToday" style="text-align: center;" >
        <a href="index.php?year=<?= date('y'); ?>&month=<?= date('m'); ?>">TODAY</a>
        <a id="home" href="./index.php">HOME</a>
    </div>

</body>
</html>
