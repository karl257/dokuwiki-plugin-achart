# Acharts Plugin for DokuWiki

The `acharts` plugin for DokuWiki makes it easy to insert interactive data charts rendered by [APEXCHARTS.JS](http://www.apexcharts.com/).

This plugin accepts the same JavaScript object that ApexCharts takes to generate a chart. Any chart describable by a static JavaScript object is supported. All types of charts natively supported by ApexCharts can be rendered.

[js-yaml v4.1.0](https://github.com/nodeca/js-yaml)

[ApexCharts v3.28.2](https://github.com/apexcharts/apexcharts.js)

## Installation
The latest ZIP package of this plugin can be downloaded [here](https://github.com/karl257/dokuwiki-plugin-acharts/archive/master.zip).

If you install this plugin manually, make sure it is installed in `lib/plugins/achart/` - if the folder is called different it may not work.

Please refer to the [DokuWiki document](http://www.dokuwiki.org/plugins) for additional info on how to install plugins in DokuWiki.

Here are a few screenshots of the rendered charts:

![Line Chart with Annotations](https://i.imgur.com/HvWG7Lk.png)

![Bar chart](https://i.imgur.com/h3TPT0D.png)

![Pie chart](https://i.imgur.com/qS26V9z.png)

For more examples, check the [Exemples](https://apexcharts.com/javascript-chart-demos).

## Usage

### Data from a local file

```
<achart url=:wiki:convertcsv.csv height=320px align=center>
{
  chart: {
      height: 350,
      type: 'bar',
  },
  dataLabels: {
      enabled: false
  },
  title: {
      text: "Ajax Example",
  }
}
</achart>
```

### Data from a remote file
```
<achart url=https://gist.github.com/karl257/6e799cc0d8a5e47ac11d97672a6890dc/raw/0a80ea7ff3b89d0f376aec0eff0d817550b32334/convertcsv.csv height=320px align=center>
{
  chart: {
      height: 350,
      type: 'bar',
  },
  dataLabels: {
      enabled: false
  },
  title: {
      text: "From web",
  }
}
</achart>
```

### Add data directly

```
var options = {
    chart: {
        width: 380,
        type: 'pie',
        toolbar: { show: true,tools: { download: true } },
    },
    labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
    series: [44, 55, 13, 43, 22],
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 200
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
}
```
This plugin accepts the same JavaScript object that the `new ApexCharts()` function of ApexCharts takes to render a chart. To include a chart in your DokuWiki page, simply wrap such a JavaScript object with a `<achart>` tag.

To render a pie chart for exemple:
```
<achart>
{
    chart: {
        width: 380,
        type: 'pie',
        toolbar: { show: true,tools: { download: true } },
    },
    labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
    series: [44, 55, 13, 43, 22],
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 200
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
}
</achart>
```

Also note that you can include comments in the snippet, both styles (`//` and `/* */`) are supported.

The major restriction is that the JavaScript object must be **static**, i.e. it cannot include function calls or function expressions, for security reasons.

## Options
The `<achart>` tag can carry optional attributes to customize the appearance of the chart. The attributes are separated by spaces, each specified in the format of `name=value`. Valid attributes are:

| Name     | Description |
|:--------:|:----------- |
| `width`  | Width of the chart, specified in CSS format, e.g. 50% or 320px. |
| `height` | Height of the chart, in the same format as `width`. |
| `align`  | Chart alignment, can be `left`, `right` or `center`. |

For instance to make your chart occupying half width of its container and floated to the right:
```
<achart align="right" width=50% >
  {
    ...
  }
</achart>
```

## Thanks
This plugin is based on [dokuwiki-plugin-c3chart](https://github.com/jasonxxu/dokuwiki-plugin-c3chart) created by @jasonxxu and inspired by [dokuwiki-plugin-amchart](https://github.com/35niavlys/dokuwiki-plugin-amchart) created by @35niavlys, Special thanks to them.

## More exemples ##
Visit [apexcharts.com](https://apexcharts.com/javascript-chart-demos/)

## Todo

Support Pdf and ODT export

## License
Copyright (C) Karl Nickel

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; version 2 of the License

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

See the COPYING file in your DokuWiki folder for details
