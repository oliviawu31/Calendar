<?php
// 取得當前的月份和年份，若沒有透過URL傳遞則使用當前月份和年份
$month = isset($_GET['month']) ? $_GET['month'] : date("m");
$year = isset($_GET['year']) ? $_GET['year'] : date("Y");

// 計算上一個月的年月
$prevMonth = $month - 1;
if ($prevMonth < 1) {
    $prevMonth = 12; // 如果是1月，則上一個月是12月
    $prevYear = $year - 1; // 需將年份減少1
} else {
    $prevYear = $year;
}

// 計算下一個月的年月
$nextMonth = $month + 1;
if ($nextMonth > 12) {
    $nextMonth = 1; // 如果是12月，則下一個月是1月
    $nextYear = $year + 1; // 需將年份增加1
} else {
    $nextYear = $year;
}

// 每年特別的日期
$spDate = [
    '2024-11-07' => "立冬",
    '2024-11-22' => '小雪'
];

// 每年固定的假期
$holidays = [
    '01-01' => "元旦",
    '02-10' => "春節", // 例子：2024年春節是2月10日
    '06-25' => "端午節", // 例子：2024年端午節是6月25日
    '09-17' => "中秋節", // 例子：2024年中秋節是9月17日
    '12-25' => "聖誕節",
];

// 計算當月的第一天是星期幾
$firstDay = "$year-$month-01"; // 取得當月的第一天
$firstDayTime = strtotime($firstDay); // 將第一天轉換為時間戳
$firstDayWeek = date("w", $firstDayTime); // 取得第一天是星期幾，0為星期日

// 取得當月有多少天
$daysInMonth = date("t", $firstDayTime);  // 當月的天數
?>

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
        .holiday {
            background-color: lightblue;
            color: #999;
        }
        .grey-text {
            color: #999;
        }
        .today {
            background: lightpink;
            color: white;
            font-weight: bolder;
        }
        .nav {
            width: 100%;
            margin: auto;
        }
        .nav table td {
            border: 0px;
            padding: 0;
            background-color: lightblue;
        }
        a {
            text-decoration: none;
            padding: 5px;
            color: blue;
        }
        a:hover {
            color: orange;
        }
        /* 週末的背景色設為粉紅 */
        .weekend {
            background-color: #f8b4d9;
        }

    </style>
</head>
<body>
<a id="home" href="./index.html">Home</a>

<h1>萬年曆</h1>

<div class="nav">
    <table style="width:100%">
        <tr>
            <td style='text-align:left'>
                <a href="calendar.php?year=<?= $prevYear; ?>&month=<?= $prevMonth; ?>">上一個月</a>
                <a href="calendar.php?year=<?= $prevYear; ?>&month=<?= $prevMonth; ?>">前年</a>
            </td>
            <td>
                <?= $year; ?> 年 <?= $month; ?> 月
            </td>
            <td style='text-align:right'>
                <a href="calendar.php?year=<?= $nextYear; ?>&month=<?= $nextMonth; ?>">下一個月</a>
                <a href="calendar.php?year=<?= $nextYear; ?>&month=<?= $nextMonth; ?>">明年</a>
            </td>
        </tr>
    </table>
</div>

<table>
<tr>
    <td>一</td>
    <td>二</td>
    <td>三</td>
    <td>四</td>
    <td>五</td>
    <td>六</td>
    <td>日</td>
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
            $currentDay = $daysShown - $firstDayWeek + 1; // 日期開始的偏移
            $theDayTime = strtotime("$currentDay days", $firstDayTime);
            $day = date("d", $theDayTime); // 取得日（1-31）
            $dateStr = date("Y-m-d", $theDayTime); // 格式化成 "YYYY-MM-DD" 格式

            // 判斷是否為本月日期
            $theMonthClass = (date("m", $theDayTime) == $month) ? '' : 'grey-text';
            // 判斷是否為今天的日期
            $isTodayClass = ($dateStr == date("Y-m-d")) ? 'today' : '';
            // 判斷是否為週末（週日和週六）
            $isWeekendClass = (date("w", $theDayTime) == 0 || date("w", $theDayTime) == 6) ? 'weekend' : '';

            echo "<td class='$theMonthClass $isTodayClass $isWeekendClass'>$day"; // 顯示日期
            if (isset($spDate[$dateStr])) {
                echo "<br>{$spDate[$dateStr]}";
            }
            if (isset($holidays[date("m-d", $theDayTime)])) {
                echo "<br>{$holidays[date("m-d", $theDayTime)]}";
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

</body>
</html>
