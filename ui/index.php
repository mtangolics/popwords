<!DOCTYPE HTML>
<html>
    <head>
	<style type="text/css">
		body {
			font-family: Verdana;
		}
		h1 {
			text-align: center;
		}
		div#menu, div#container {
			text-align: center;
			width: 650px;
			margin-left: auto;
			margin-right: auto;
		}
	</style>
    <script type="text/javascript" src="protovis-d3.2.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.1.js"></script>
	<script type="text/javascript">
	$(function() {
		var wordCache = {};
        
	        var sortMap = function(a,b)
	        {
	            return b.Value - a.Value;
	        }

		
		var selectYear = function(year) {
			if(!wordCache[year])
			{
				jQuery.getJSON('lyrics.php?year=' + year, function(data) {
		                        var lyricMap = data.Attribute.sort(sortMap);
		                        lyricMap = lyricMap.slice(0,40);
					wordCache[year] = lyricMap;
		                        renderCloud(lyricMap);
				});
			}
	                else
	                {
	                    renderCloud(wordCache[year]);
	                }
		};
		
		jQuery("#yearCombo").change(function(event) {
			selectYear(jQuery(this).val());
		});
		jQuery("#yearCombo").change();
	});


  </script>
  </head>
  <body>
    <script type="text/javascript+protovis">
	//var test = pv.flatten(flare).leaf(Number).array();
	/* Produce a flat hierarchy of the Flare classes. */
	function renderCloud(array)
	{
		var classes = pv.nodes(array);

		var vis = new pv.Panel()
			.width(600)
			.height(600)
			.canvas("visualization");

		vis.add(pv.Layout.Pack)
			.top(-50)
			.bottom(-50)
			.nodes(classes)
			.size(function(d) d.nodeValue.Value)
			.spacing(0)
			.order(null)
		  .node.add(pv.Dot)
			.fillStyle(pv.Colors.category20().by(function(d) d.nodeValue.Name))
			.strokeStyle(function() this.fillStyle().darker())
			.visible(function(d) d.parentNode)
			.title(function(d) d.nodeValue.Value)
		  .anchor("center").add(pv.Label)
			.text(function(d) d.nodeValue.Name);
			
		vis.render();
	}

</script> 
    </head>
    <body>
		<h1>PopWords</h1>
		<div id="menu">
			Select a Year: <select id="yearCombo">
				<option value="2010">2010</option>
				<option value="2009">2009</option>
				<option value="2008">2008</option>
				<option value="2007">2007</option>
				<option value="2006">2006</option>
				<option value="2005">2005</option>
				<option value="2004">2004</option>
				<option value="2003">2003</option>
				<option value="2002">2002</option>
				<option value="2001">2001</option>
				<option value="2000">2000</option>
			</select>
		</div>
		<div id="container">
			<div id="visualization"/>
		</div>
	</body>
</html>