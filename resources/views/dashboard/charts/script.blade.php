<script>
	$(function () {
        let url = "{{ route('api.chart') }}";

        $.ajax({
            url: url,
            headers: {
								'Authorization': 'Bearer ' + localStorage.getItem('token'),
                'Accept': 'application/json'
            },
            success: function (response) {
                let chart = initChart(response);
                chart.render();
            }
        });

        function initChart(data) {
            var options = {
                plotOptions: {
                    bar: {
                        horizontal: false,
                        dataLabels: {
                            position: 'bottom'
                        }
                    }
                },
                chart: {
                    type: "bar",
                    height: 300
                },
                series: [
                    {
                        name: "Transaksi",
                        data: [
                            data.data.jul,
                            data.data.agu,
                            data.data.sep,
                            data.data.okt,
                            data.data.nov,
                            data.data.des,
                            data.data.jan,
                            data.data.feb,
                            data.data.mar,
                            data.data.apr,
                            data.data.mei,
                            data.data.jun,
                        ],
                    },
                ],
                xaxis: {
                    categories: [
												"Jul",
                        "Agu",
                        "Sep",
                        "Okt",
                        "Nov",
                        "Des",
                        "Jan",
                        "Feb",
                        "Mar",
                        "Apr",
                        "Mei",
                        "Jun",
                    ],
                },
            };

            var chart = new ApexCharts(
                document.querySelector("#cash-transaction-chart-dashboard"),
                options
            );

            return chart;
        }
    });
</script>
