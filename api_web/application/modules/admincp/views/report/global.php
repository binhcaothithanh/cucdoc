<div class="content-wrapper" style="min-height: 916px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Thống kê doanh thu</h1>

        <select id="month" class="form-control" id="order" style="width:  150px;float: left;margin-right: 10px;">
            <?php for ($i = 1; $i < 13; $i++): ?>
                <option <?php echo $i == $month_now ? "selected" : ''; ?> value="<?php echo $i; ?>">Tháng <?php echo $i; ?></option>
            <?php endfor; ?>
        </select>
        <select id="year" class="form-control" id="order" style="width:  150px;float: left;margin-right: 10px;">
            <?php $year = date('Y'); ?>
            <option><?php echo $year - 1; ?></option>
            <option selected=""><?php echo $year; ?></option>   
        </select>

    </section>
    <br/><br/>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div id="temp"></div>
            <div id="chart"></div>
        </div><!-- /.col -->
    </section>
</div>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script>
    function formatDollar(num) {
        var more = '';
        if (num < 0) {
            num *= -1;
            more = '-';
        }
        var p = num + '';
        return more + p.split("").reverse().reduce(function (acc, num, i, orig) {
            return  num + (i && !(i % 3) ? "," : "") + acc;
        }, "");
    }
    function get_report() {
        var month = $('#month').val();
        var year = $('#year').val();
        $.post('/<?php echo ADMIN_URL ?>report/get_global_report', {month: month, year: year}, function (result) {
            if (result) {
                result = JSON.parse(result);
                if ($.isEmptyObject(result.online)) {
                    $('#chart').html('<br/><h2>Không có doanh thu trong tháng này</h2>');
                    return false;
                }
                var categories = [], data_online = [], data_offline = [], total = 0, total_offline = 0, total_online = 0, cost_price_online_total = 0, cost_price_offline_total = 0;
                var max_day = parseInt(result.max_day);
                for (var i = 1; i <= max_day; i++) {
                    var curr_day = i > 9 ? i : '0' + i;
                    var curr_date = curr_day + '-' + result.my;
                    if (typeof result.online[curr_date] != "undefined") {
                        var money = parseInt(result.online[curr_date]['global_total']);
                        cost_price_online_total += parseInt(result.online[curr_date]['cost_price_total']);
                        data_online.push(money);
                        total_online += money;
                    } else {
                        data_online.push(0);
                    }

                    categories.push(curr_day);
                }
                total = total_online + total_offline;
                $('#chart').highcharts({
                    title: {
                        text: 'Doanh thu trong tháng ' + month + ' : ' + formatDollar(total_online) + '<u>đ</u></span>',
                        x: -20 //center
                    },
                    xAxis: {
                        categories: categories
                    },
                    yAxis: {
                        title: {
                            text: ''
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }]
                    },
                    tooltip: {
                        valueSuffix: 'đ'
                    },
                    series: [{name: 'Doanh thu ', data: data_online}]
                });

            }
            $('text:contains("Highcharts.com")').remove();
//            $('g:contains("Doanh thu")').remove();
        });

    }
    get_report();
    $('#month').change(function () {
        get_report();
    })
    $('#year').change(function () {
        get_report();
    })
</script>