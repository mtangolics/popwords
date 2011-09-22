<!DOCTYPE HTML>
<html>
    <head>
    <script type="text/javascript" src="protovis-d3.2.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.1.js"></script>
	<script type="text/javascript">
	$(function() {
		var wordCache = {};
		
		var selectYear = function(year) {
				if(!wordCache[year])
				{
					jQuery.getJSON('lyrics.php?year=' + year, function(data) {
						wordCache[year] = data;
                        renderCloud(data.Attribute);
					});
				}
                else
                {
                    renderCloud(wordCache[year].Attribute);
                }
		};
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
			.height(600);

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
		<select id="yearCombo"/>
    </body>
</html>