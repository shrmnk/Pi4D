		<hr>
		<div class="row footer">
			<div class="col-xs-12 text-center text-muted">
			<span class="next-refresh">(Next Refresh unset)</span>
			<br>
			Pi4D Version <?php echo($this->version); ?> &middot; by <a style="text-decoration: none; color: #999;"href="http://www.shrmn.com/">Shrmn K</a>
			</div>
		</div>
	</div> <!-- /container -->
    <!-- Lightweight jQuery alternative -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zepto/1.1.6/zepto.min.js"></script>
	<!-- The script below handles the refreshing of the page based on several conditions -->
	<!-- But we try to minimise the load on the API endpoint as much as possible -->
	<script type="text/javascript">
		/* We need to do an immediate (rate-limited) refresh of the page based upon these conditions:
		1. If the current shown result is more than 4 days back (maximum gap between 2 result days is 3 days)
		2. If today is Saturday 7pm and the result is Wednesday
		3. If today is Sunday 7pm and the result is still Saturday
		4. If today is Wednesday 7pm and the result is still Sunday
		
		Noting that we should only set a timeout to call a refresh within the next 3 minutes (i.e. at minute #00, 03, 06, 09, 12, etc.)
		
		Otherwise, it will wait until the next result day (Wed/Sat/Sun) at 7pm to refresh.
		*/
		
		var refreshAtMinuteInterval = 3;
		var refreshCoefficient = 1000 * 60;
		var currentDate = new Date();
		var refreshTimeout;
		
		<?php if(!$this->success) { ?>
		$(document).ready(function() {
			var refreshDate = new Date(Math.round((currentDate.getTime() + refreshAtMinuteInterval * refreshCoefficient) / refreshCoefficient) * refreshCoefficient);
			$(".next-refresh").html("Next refresh set to " + refreshDate.toString());
			refreshTimeout = setTimeout(function() { location.reload(); }, refreshDate.getTime() - currentDate.getTime());
		});
		<?php } else { ?>
		var resultDate = new Date(<?php echo($this->resulttimestamp * 1000); ?>);
		
		function setNextRefresh() {
			var refreshDate = new Date(Math.round((currentDate.getTime() + refreshAtMinuteInterval * refreshCoefficient) / refreshCoefficient) * refreshCoefficient);
			$(".next-refresh").html("Next refresh set to " + refreshDate.toString());
			refreshTimeout = setTimeout(function() { location.reload(); }, refreshDate.getTime() - currentDate.getTime());
		}
		
		function setNextResultDayRefresh() {
			// Check on next result day
			var shrinkToDayCoefficient = 1000 * 60 * 60 * 24;
			var shrinkToHoursCoefficient = 1000 * 60 * 60;
			
			if(currentDate.getDay() == 6 && currentDate.getHours() >= 19) {
				// Saturday -> Check on Sunday
				var refreshDate = new Date(Math.floor( (currentDate.getTime() + 1*shrinkToDayCoefficient) / shrinkToDayCoefficient) * shrinkToDayCoefficient);
				$(".next-refresh").html("Loaded on Saturday > 7pm, Next refresh set to " + refreshDate.toString());
			} else if(currentDate.getDay() == 0 && currentDate.getHours() >= 19) {
				// Sunday -> Check on Wednesday
				var refreshDate = new Date(Math.floor( (currentDate.getTime() + 3*shrinkToDayCoefficient) / shrinkToDayCoefficient) * shrinkToDayCoefficient);
				$(".next-refresh").html("Loaded on Sunday > 7pm, Next refresh set to " + refreshDate.toString());
			} else if(currentDate.getDay() == 3 && currentDate.getHours() >= 19) {
				// Wednesday -> Check on Saturday
				var refreshDate = new Date(Math.floor( (currentDate.getTime() + 3*shrinkToDayCoefficient) / shrinkToDayCoefficient) * shrinkToDayCoefficient);
				$(".next-refresh").html("Loaded on Wednesday > 7pm, Next refresh set to " + refreshDate.toString());
			} else {
				// Otherwise, it means that we are on result day but its not 7pm yet.
				var refreshDate = new Date(Math.floor( (currentDate.getTime() + (19 - currentDate.getHours())*shrinkToHoursCoefficient) / shrinkToHoursCoefficient) * shrinkToHoursCoefficient);
				$(".next-refresh").html("Loaded on Result Day < 7pm, Next refresh set to " + refreshDate.toString());
			}
			
			refreshTimeout = setTimeout(function() { location.reload(); }, refreshDate.getTime() - currentDate.getTime());
		}
		
		$(document).ready(function() {
			// Condition 1
			if(Math.floor((currentDate.getTime() - resultDate.getTime())/(1000*60*60*24)) > 3) { setNextRefresh(); }
			// Condition 2: Its Saturday, but showing old Wed result (>= 7pm)
			else if( (currentDate.getDay() == 6 && resultDate.getDay() == 3) && currentDate.getHours() >= 19) { setNextRefresh(); }
			// Condition 3: Its Sunday, but showing old Saturday result (>= 7pm)
			else if( (currentDate.getDay() == 0 && resultDate.getDay() == 6) && currentDate.getHours() >= 19) { setNextRefresh(); }
			// Condition 4: Its Wednesday, but showing old Sunday result (>= 7pm)
			else if( (currentDate.getDay() == 3 && resultDate.getDay() == 0) && currentDate.getHours() >= 19) { setNextRefresh(); }
			// Give up - set to refresh on next result day at 7pm
			else { setNextResultDayRefresh(); }
		});
		<?php } ?>
	</script>
  </body>
</html>
