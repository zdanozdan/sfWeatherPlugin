<style>
#weather
{
    
}

#weather td
{
    padding: 5px;
}

#weather td.temp
{
    background: #930918;
    color: #fff;
    font-weight: bold;
    font-family: verdana, arial;
}

#weather td.days
{
    background: #919191;
    color: #fff;
    font-weight: bold;
    font-family: verdana, arial;
}

#weather td.days_icon
{
    width: 41px;
    height: 31px;

    border-top: 1px solid #DEDEDE;
    border-left: 1px solid #DEDEDE;
}

#weather td.days_icon_last
{
    width: 41px;
    height: 31px;

    border-top: 1px solid #DEDEDE;
    border-left: 1px solid #DEDEDE;
    border-right: 1px solid #DEDEDE;
}

#weather td.info
{
    border-left: 1px solid #DEDEDE;
    border-right: 1px solid #DEDEDE;
    border-top: 1px solid #DEDEDE;
    padding-left: 10px;
}

#weather td.icon
{
    border-top: 1px solid #DEDEDE;
    border-left: 1px solid #DEDEDE;
    width: 93px;
}
</style>

<?php $skin = 'Sticker'; ?>

<table id="weather" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td colspan="1" rowspan="2" class="icon" align="center"><img src="/sfWeatherPlugin/img/<?php echo $skin; ?>/big/<?php echo $w['cc']['icon']; ?>.png" alt="" /></td>
        <td colspan="4" class="info">
            <div style="padding-bottom: 5px;"><b><?php echo format_date(time(), 'dddd, dd MMMM yyyy') ?></b></div>
            <div><b><?php echo $w['loc']['dnam']; ?></b></div>
        </td>
    </tr>
    <tr>
        <?php for($i = 1; $i <= 4; $i++): ?>
            <td align="center" class="<?php echo $i == 4 ? 'days_icon_last' : 'days_icon'; ?>"><img src="/sfWeatherPlugin/img/<?php echo $skin; ?>/small/<?php echo $w['dayf']['day'][$i]['part'][0]['icon']; ?>.png" alt="" /></td>
        <?php endfor; ?>
    </tr>
    <tr>
        <td align="center" class="temp"><?php echo $w['dayf']['day'][0]['low'];  ?>° < <?php if($w['dayf']['day'][0]['hi'] == 'N/A'){echo $w['cc']['tmp'];}else{echo $w['dayf']['day'][0]['hi'];} ?>°</td>
        <?php for($i = 1; $i <= 4; $i++): ?>
            <td align="center" class="days"><?php echo substr(strtoupper(format_date(strtotime($w['dayf']['day'][$i]['t']), 'EEE')), 0, 3); ?></td>
        <?php endfor; ?>
    </tr>
</table>

<?php //echo '<pre>'; print_r($w); ?>