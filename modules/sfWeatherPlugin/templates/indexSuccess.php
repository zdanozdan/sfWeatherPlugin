<style>
/* Weather */
#weather
{
    width: 300px;
    margin: 0px auto;
    background: #3A4D6E;
    border: 4px solid #677487;
    -moz-border-radius: 10px;
    margin-top: 100px;
    position: relative;
}

#weather .bigimage
{
    position: absolute;
    margin-left: 110px;
    margin-top: -50px;
}

#weather table.current
{
    margin-top: 20px;
}

#weather table.forecast
{
    margin-bottom: 20px;
}

#weather table.forecast,
#weather table.current
{
    width: 100%;
}

#weather table.forecast tr.color
{
    background: #455D81;
}

#weather table.forecast td, 
#weather table.current td
{
    font-family: 'Arial';
    font-weight: bold;
    font-size: 16px;
}

#weather table.forecast td
{
    border-top: 2px solid #314055;
}

#weather table.current td.locale
{
    padding: 5px 10px;
    color: #FFFFFF;
}

#weather table.current td.locale div
{
    font-size: 18px;
}

#weather table.current td.locale div.temp
{
    color: #BBCADD;
    font-size: 14px;
}

#weather table.current td.temp
{
    font-size: 68px;
    color: #FFFFFF;
    width: 100px;
    font-weight: normal;
    text-align: right;
    padding-right: 10px;
}

#weather table.forecast td.days
{
    color: #FFFCF9;
    text-transform: uppercase;
    padding: 5px 0px 5px 10px;
    width: 120px;
}

#weather table.forecast td.images
{
    text-align: center;
    padding: 1px 0px;
}

#weather table.forecast td.high
{
    color: #FFFFFF;
    width: 40px;
    text-align: center;
    font-size: 24px;
}

#weather table.forecast td.low
{
    color: #7792BF;
    width: 40px;
    text-align: center;
    font-size: 24px;
}
</style>

<?php $skin = 'Default'; ?>

<div id="weather">
<div class="bigimage">
    <img src="/sfWeatherPlugin/img/<?php echo $skin; ?>/big/<?php echo $w['cc']['icon']; ?>.png" alt="" />
</div>
<table cellpadding="0" cellspacing="0" border="0" class="current">
    <tr>
        <td class="locale" valign="bottom">
            <div class="city"><?php echo substr($w['loc']['dnam'], 0, strpos($w['loc']['dnam'], ',')); ?></div>
            <div class="temp">Max : <?php if($w['dayf']['day'][0]['hi'] == 'N/A'){echo $w['cc']['tmp'];}else{echo $w['dayf']['day'][0]['hi'];} ?>°&nbsp;&nbsp;Min : <?php echo $w['dayf']['day'][0]['low'];  ?>°</div>
        </td>
        <td class="temp"><?php echo $w['cc']['tmp']; ?>°</td>
    </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" class="forecast">
    <?php $color = true; ?>
    <?php foreach($w['dayf']['day'] as $values): ?>
    <tr <?php if($color){echo 'class="color"';$color=false;}else{$color=true;}?>>
        <td class="days"><?php echo format_date(strtotime($values['t']), 'dddd', 'fr_CH'); ?></td>
        <td class="images"><img src="/sfWeatherPlugin/img/<?php echo $skin; ?>/small/<?php echo $values['part'][0]['icon']; ?>.png" alt="" /></td>
        <td class="high"><?php if($values['hi'] == 'N/A'){echo $w['cc']['tmp'];}else{echo $values['hi'];} ?>°</td>
        <td class="low"><?php echo $values['low']; ?>°</td>
    </tr>
    <?php endforeach; ?>
</table>
</div>
<?php //echo '<pre>'; print_r($w); ?>