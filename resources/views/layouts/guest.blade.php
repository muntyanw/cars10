@extends('layouts.app')

@section('title')
    @yield('title')
@endsection

@section('style')
    @yield('style')

@endsection

@section('content')
    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success mb-4">
            {{ session('status') }}
        </div>
    @endif
    <svg class="main-login__pattern" preserveAspectRatio="xMidYMid slice" width="1136" height="2324" viewBox="0 0 1136 2324" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g opacity="0.06" clip-path="url(#clip0_93_338)">
            <path d="M1149.02 4.93951L796.293 938.665L-72 1328.11M1133.38 -11.4571L780.652 922.268L-86.5016 1311.2M1117.75 -27.8652L765.012 905.872L-101.015 1294.3M1102.11 -44.2597L749.383 889.477L-115.517 1277.4M1086.47 -60.6562L733.743 873.08L-130.03 1260.49M1070.83 -77.0527L718.102 856.672L-144.532 1243.58M1055.2 -93.4472L702.462 840.278L-159.045 1226.69M1039.56 -109.844L686.833 823.881L-173.547 1209.78M1023.92 -126.24L671.192 807.485L-188.061 1192.87M1008.29 -142.635L655.551 791.09L-202.562 1175.98M992.648 -159.031L639.922 774.694L-217.076 1159.07M977.007 -175.439L624.282 758.297L-231.577 1142.16M961.367 -191.834L608.642 741.903L-246.091 1125.26M945.738 -208.23L593.001 725.506L-260.592 1108.36M930.097 -224.627L577.372 709.098L-275.106 1091.45M914.457 -241.021L561.732 692.704L-289.608 1074.55M898.828 -257.418L546.091 676.307L-304.121 1057.65M883.188 -273.814L530.462 659.911L-318.623 1040.74M867.547 -290.209L514.822 643.516L-333.136 1023.84M851.906 -306.617L499.181 627.12L-347.638 1006.93M836.277 -323.012L483.541 610.725L-362.151 990.036M820.637 -339.408L467.912 594.328L-376.653 973.129M804.997 -355.805L452.271 577.92L-391.166 956.221M789.367 -372.199L436.63 561.526L-405.669 939.315M773.727 -388.596L421.002 545.129L-420.181 922.419M758.087 -404.992L405.361 528.733L-434.683 905.512M742.458 -421.387L389.721 512.339L-449.197 888.606M726.817 -437.783L374.08 495.942L-463.698 871.709M711.176 -454.191L358.451 479.545L-478.212 854.802M695.536 -470.586L342.811 463.151L-492.713 837.896M679.907 -486.982L327.17 446.754L-507.227 820.988M664.267 -503.379L311.542 430.346L-521.729 804.092M648.626 -519.773L295.901 413.952L-536.242 787.186M632.997 -536.17L280.26 397.555L-550.744 770.278M617.357 -552.566L264.62 381.159L-565.257 753.382M601.716 -568.961L248.991 364.764L-579.759 736.476M586.076 -585.357L233.351 348.368L-594.272 719.569M570.447 -601.766L217.71 331.971L-608.774 702.661M554.806 -618.16L202.081 315.576L-623.288 685.766M539.166 -634.556L186.441 299.169L-637.789 668.859M523.537 -650.953L170.8 282.772L-652.303 651.951M507.896 -667.348L155.171 266.378L-666.805 635.045M492.256 -683.744L139.531 249.981L-681.306 618.149M476.615 -700.141L123.89 233.584L-695.819 601.241M460.986 -716.535L108.25 217.19L-710.321 584.335M445.346 -732.943L92.6207 200.793L-724.835 567.439M429.705 -749.338L76.98 184.399L-739.337 550.533M414.076 -765.734L61.3395 168.002L-753.85 533.626M398.436 -782.131L45.7105 151.594L-768.352 516.718M382.796 -798.525L30.0704 135.2L-782.865 499.824M367.155 -814.922L14.4297 118.803L-797.367 482.916M351.526 -831.318L-1.21082 102.407L-811.88 466.008M335.885 -847.713L-16.8398 86.0123L-826.382 449.114M320.245 -864.11L-32.4802 69.6155L-840.895 432.206M304.616 -880.518L-48.121 53.2191L-855.397 415.298M288.976 -896.912L-63.7495 36.8246L-869.91 398.392M273.335 -913.309L-79.3901 20.4282L-884.412 381.496M-83.5617 2319.67L243.39 1305.28L1131.15 855.256M-64.8071 2334.34L261.936 1320.59L1149.19 870.815M-46.0523 2349.01L280.481 1335.91L1167.24 886.387M-27.2977 2363.67L299.027 1351.21L1185.28 901.945M-8.55475 2378.35L317.584 1366.52L1203.33 917.516M10.2001 2393.01L336.13 1381.83L1221.38 933.074M28.955 2407.69L354.675 1397.14L1239.42 948.647M47.7091 2422.35L373.22 1412.45L1257.47 964.205M66.4639 2437.03L391.766 1427.76L1275.51 979.776M85.2184 2451.69L410.311 1443.08L1293.55 995.334M103.973 2466.37L428.857 1458.38L1311.59 1010.91M122.728 2481.03L447.402 1473.7L1329.64 1026.46M141.483 2495.7L465.96 1489L1347.69 1042.04M160.237 2510.37L484.505 1504.31L1365.73 1057.6M178.98 2525.04L503.051 1519.62L1383.78 1073.17M197.735 2539.71L521.596 1534.93L1401.82 1088.72M216.49 2554.38L540.142 1550.25L1419.87 1104.3M235.245 2569.06L558.687 1565.55L1437.9 1119.86M253.999 2583.72L577.233 1580.87L1455.95 1135.41M272.754 2598.39L595.778 1596.17L1473.99 1150.98M291.509 2613.06L614.335 1611.49L1492.04 1166.54M310.263 2627.72L632.881 1626.79L1510.09 1182.12M329.018 2642.4L651.427 1642.1L1528.13 1197.67M347.761 2657.06L669.972 1657.42L1546.18 1213.24M366.516 2671.74L688.518 1672.72L1564.22 1228.8M385.271 2686.41L707.063 1688.04L1582.26 1244.38M404.025 2701.08L725.609 1703.34L1600.3 1259.93M422.78 2715.74L744.154 1718.66L1618.35 1275.5M441.535 2730.42L762.711 1733.96L1636.4 1291.06M460.289 2745.09L781.257 1749.28L1654.44 1306.63M479.044 2759.75L799.803 1764.59L1672.49 1322.19M497.799 2774.43L818.348 1779.9L1690.53 1337.77M516.542 2789.09L836.894 1795.21L1708.58 1353.32M535.297 2803.77L855.439 1810.51L1726.61 1368.89M554.051 2818.43L873.985 1825.83L1744.66 1384.45M572.806 2833.11L892.53 1841.13L1762.71 1400.03M591.561 2847.77L911.088 1856.45L1780.75 1415.58M610.315 2862.45L929.632 1871.76L1798.8 1431.15M629.069 2877.11L948.178 1887.06L1816.84 1446.71M647.824 2891.78L966.723 1902.38L1834.89 1462.29M666.578 2906.45L985.269 1917.68L1852.93 1477.84M685.322 2921.12L1003.81 1933L1870.98 1493.41M704.076 2935.79L1022.36 1948.32L1889.01 1508.97M722.831 2950.46L1040.91 1963.62L1907.06 1524.54M741.586 2965.13L1059.46 1978.93L1925.11 1540.1M760.34 2979.8L1078.01 1994.24L1943.15 1555.67M779.095 2994.48L1096.55 2009.55L1961.2 1571.23M797.85 3009.14L1115.1 2024.86L1979.24 1586.8M816.605 3023.8L1133.64 2040.17L1997.29 1602.36M835.359 3038.48L1152.19 2055.48L2015.34 1617.93M854.114 3053.14L1170.74 2070.79L2033.37 1633.49M872.857 3067.82L1189.28 2086.1L2051.42 1649.06M891.612 3082.48L1207.84 2101.41L2069.46 1664.62M910.367 3097.16L1226.38 2116.72L2087.51 1680.2M929.121 3111.83L1244.93 2132.03L2105.55 1695.75M947.876 3126.5L1263.48 2147.34L2123.6 1711.32M966.631 3141.16L1282.02 2162.66L2141.65 1726.88" stroke="url(#paint0_linear_93_338)" stroke-miterlimit="10"/>
        </g>
        <defs>
            <linearGradient id="paint0_linear_93_338" x1="1555.48" y1="1726.88" x2="1555.48" y2="3141.16" gradientUnits="userSpaceOnUse">
                <stop stop-color="#1B8842"/>
                <stop offset="0.916667" stop-color="#F9F9F9"/>
            </linearGradient>
            <clipPath id="clip0_93_338">
                <rect width="2324" height="1136" fill="white" transform="translate(1136) rotate(90)"/>
            </clipPath>
        </defs>
    </svg>
    @yield('content')
@endsection

@section('scripts')
    @yield('scripts')
@endsection