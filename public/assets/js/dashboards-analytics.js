/**
 * Dashboard Analytics
 */

'use strict';



(function () {
  let cardColor, headingColor, axisColor, shadeColor, borderColor;

  cardColor = config.colors.cardColor;
  headingColor = config.colors.headingColor;
  axisColor = config.colors.axisColor;
  borderColor = config.colors.borderColor;

  // Total Revenue Report Chart - Bar Chart
    // --------------------------------------------------------------------



  fetch('/dashboard/chart-data')
        .then(response => response.json())
        .then(data => {
            const kecamatans = data;

            // Mengambil nama kecamatan dan pendapatannya
            const kecamatanNames = kecamatans.map(kecamatan => kecamatan.nama_kecamatan);
            const kecamatanNeed = kecamatans.map(kecamatan => kecamatan.kebutuhan_beras);

            // Mengganti data pada series dengan data kecamatan
            const totalRevenueChartOptions = {
                series: [{
                    name: 'Permintaan Beras (Kg)', // Ubah nama series jika diperlukan
                    data: kecamatanNeed
                }],
                chart: {
                    height: 300,
                    stacked: true,
                    type: 'bar',
                    toolbar: { show: false }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '33%',
                        borderRadius: 12,
                        startingShape: 'rounded',
                        endingShape: 'rounded'
                    }
                },
                colors: [config.colors.primary],
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: true,
                    horizontalAlign: 'left',
                    position: 'top',
                    markers: {
                        height: 8,
                        width: 8,
                        radius: 12,
                        offsetX: -3
                    },
                    labels: {
                        colors: axisColor
                    },
                    itemMargin: {
                        horizontal: 10
                    }
                },
                grid: {
                    borderColor: borderColor,
                    padding: {
                        top: 0,
                        bottom: -8,
                        left: 20,
                        right: 20
                    }
                },
                xaxis: {
                    categories: kecamatanNames, // Gunakan nama kecamatan sebagai label x-axis
                    labels: {
                        style: {
                            fontSize: '13px',
                            colors: axisColor
                        }
                    },
                    axisTicks: {
                        show: false
                    },
                    axisBorder: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
            show: true, // Menampilkan label pada sumbu y
            formatter: function(value) {
            return new Intl.NumberFormat('id-ID').format(value); // Format angka menjadi format mata uang Indonesia
            }
        },
                },
                responsive: [
                    // Responsif lainnya seperti sebelumnya
                ],
                states: {
                    hover: {
                        filter: {
                            type: 'none'
                        }
                    },
                    active: {
                        filter: {
                            type: 'none'
                        }
                    }
                }
            };

            // Render chart
            const totalRevenueChartEl = document.querySelector('#totalRevenueChart');
            const totalRevenueChart = new ApexCharts(totalRevenueChartEl, totalRevenueChartOptions);
            totalRevenueChart.render();
        })
        .catch(error => {
            console.error('Error fetching kecamatan data:', error);
        })
  // Growth Chart - Radial Bar Chart
  // --------------------------------------------------------------------



  // Income Chart - Area chart
  // --------------------------------------------------------------------
//   const incomeChartEl = document.querySelector('#incomeChart'),
//     incomeChartConfig = {
//       series: [
//         {
//           data: [24, 21, 30, 22, 42, 26, 35, 29]
//         }
//       ],
//       chart: {
//         height: 215,
//         parentHeightOffset: 0,
//         parentWidthOffset: 0,
//         toolbar: {
//           show: false
//         },
//         type: 'area'
//       },
//       dataLabels: {
//         enabled: false
//       },
//       stroke: {
//         width: 2,
//         curve: 'smooth'
//       },
//       legend: {
//         show: false
//       },
//       markers: {
//         size: 6,
//         colors: 'transparent',
//         strokeColors: 'transparent',
//         strokeWidth: 4,
//         discrete: [
//           {
//             fillColor: config.colors.white,
//             seriesIndex: 0,
//             dataPointIndex: 7,
//             strokeColor: config.colors.primary,
//             strokeWidth: 2,
//             size: 6,
//             radius: 8
//           }
//         ],
//         hover: {
//           size: 7
//         }
//       },
//       colors: [config.colors.primary],
//       fill: {
//         type: 'gradient',
//         gradient: {
//           shade: shadeColor,
//           shadeIntensity: 0.6,
//           opacityFrom: 0.5,
//           opacityTo: 0.25,
//           stops: [0, 95, 100]
//         }
//       },
//       grid: {
//         borderColor: borderColor,
//         strokeDashArray: 3,
//         padding: {
//           top: -20,
//           bottom: -8,
//           left: -10,
//           right: 8
//         }
//       },
//       xaxis: {
//         categories: ['', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
//         axisBorder: {
//           show: false
//         },
//         axisTicks: {
//           show: false
//         },
//         labels: {
//           show: true,
//           style: {
//             fontSize: '13px',
//             colors: axisColor
//           }
//         }
//       },
//       yaxis: {
//         labels: {
//           show: false
//         },
//         min: 10,
//         max: 50,
//         tickAmount: 4
//       }
//     };
//   if (typeof incomeChartEl !== undefined && incomeChartEl !== null) {
//     const incomeChart = new ApexCharts(incomeChartEl, incomeChartConfig);
//     incomeChart.render();
    //   }

    // Ambil data dari server menggunakan Axios atau fetch API
const incomeChartEl = document.querySelector('#incomeChart');

fetch('/dashboard/grafik-data')
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  })
  .then(data => {
    // Ambil kunci (bulan) dan nilai (biaya) dari respons JSON
    const bulanCategories = Object.keys(data);
    const biayaPerBulanFormatted = Object.values(data);

    // Perbarui konfigurasi grafik dengan data yang diambil dari server
    const incomeChartConfig = {
      series: [
        {
          name: 'Biaya (Rp)',
          data: biayaPerBulanFormatted
        }
      ],
      chart: {
        height: 215,
        parentHeightOffset: 0,
        parentWidthOffset: 0,
        toolbar: {
          show: false
        },
        type: 'area'
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: 2,
        curve: 'smooth'
      },
      legend: {
        show: false
      },
      markers: {
        size: 6,
        colors: 'transparent',
        strokeColors: 'transparent',
        strokeWidth: 4,
        discrete: [
          {
            fillColor: config.colors.white,
            seriesIndex: 0,
            dataPointIndex: 7,
            strokeColor: config.colors.primary,
            strokeWidth: 2,
            size: 6,
            radius: 8
          }
        ],
        hover: {
          size: 7
        }
      },
      colors: [config.colors.primary],
      fill: {
        type: 'gradient',
        gradient: {
          shade: shadeColor,
          shadeIntensity: 0.6,
          opacityFrom: 0.5,
          opacityTo: 0.25,
          stops: [0, 95, 100]
        }
      },
      grid: {
        borderColor: borderColor,
        strokeDashArray: 3,
        padding: {
          top: -20,
          bottom: -8,
          left: -10,
          right: 8
        }
      },
      xaxis: {
        categories: bulanCategories,
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          show: true,
          style: {
            fontSize: '13px',
            colors: axisColor
          }
        }
      },
      yaxis: {
        labels: {
            show: true, // Menampilkan label pada sumbu y
            formatter: function(value) {
            return new Intl.NumberFormat('id-ID').format(value); // Format angka menjadi format mata uang Indonesia
            }
        },
        min: Math.min(...biayaPerBulanFormatted), // Menggunakan nilai minimum dari data biaya
        max: Math.max(...biayaPerBulanFormatted), // Menggunakan nilai maksimum dari data biaya
        tickAmount: 4
        }
    };

    // Render grafik menggunakan konfigurasi yang diperbarui
    if (typeof incomeChartEl !== undefined && incomeChartEl !== null) {
      const incomeChart = new ApexCharts(incomeChartEl, incomeChartConfig);
      incomeChart.render();
    }
  })
  .catch(error => {
    console.error('Error fetching chart data:', error);
  });


  // Expenses Mini Chart - Radial Chart
  // --------------------------------------------------------------------
  const weeklyExpensesEl = document.querySelector('#expensesOfWeek'),
    weeklyExpensesConfig = {
      series: [65],
      chart: {
        width: 60,
        height: 60,
        type: 'radialBar'
      },
      plotOptions: {
        radialBar: {
          startAngle: 0,
          endAngle: 360,
          strokeWidth: '8',
          hollow: {
            margin: 2,
            size: '45%'
          },
          track: {
            strokeWidth: '50%',
            background: borderColor
          },
          dataLabels: {
            show: true,
            name: {
              show: false
            },
            value: {
              formatter: function (val) {
                return '$' + parseInt(val);
              },
              offsetY: 5,
              color: '#697a8d',
              fontSize: '13px',
              show: true
            }
          }
        }
      },
      fill: {
        type: 'solid',
        colors: config.colors.primary
      },
      stroke: {
        lineCap: 'round'
      },
      grid: {
        padding: {
          top: -10,
          bottom: -15,
          left: -10,
          right: -10
        }
      },
      states: {
        hover: {
          filter: {
            type: 'none'
          }
        },
        active: {
          filter: {
            type: 'none'
          }
        }
      }
    };
  if (typeof weeklyExpensesEl !== undefined && weeklyExpensesEl !== null) {
    const weeklyExpenses = new ApexCharts(weeklyExpensesEl, weeklyExpensesConfig);
    weeklyExpenses.render();
  }
})();
