<div id="rb-container">
<table id="rb-uhrzeit" class="raumbuchung" style="float: left">
	<tr>
		<!-- <th class="datum">%~date%:</th> -->
		<th class="datum"><img src="images/schedule.png" style="height:24px;" title="Datum"></th>
	</tr>	
	%optional bibliotheken1%
	<tr style="display:none"><th class="leerzelle-bibliotheken">&nbsp;</th></tr>
	%/optional bibliotheken1%
	<tr>
		<th class="arbeitsplatz-header" style="height:40px;"><img src="images/place.png" style="height:24px;" title="Standort"></th>
	</tr>
	<tr>
		<th><img src="images/community.png" style="height:24px;" title="Maximale Anzahl zugelassener Benutzer im Raum"></th>
	</tr>
	%loop_zeitabschnitte_uhrzeit%
	<tr>
		<th id="time-%period%" class="zeitabschnitt">%zeitabschnitt%</th>
	</tr>
	%/loop_zeitabschnitte_uhrzeit%
	<tr>
		<th class="zeitabschnitt"
			style="background-image: url(images/scroll-hg.gif); background-repeat: repeat-x; background-color: #d4d0c8">&nbsp;</th>
	</tr>
</table>
<div id="rb-scroll-container">
<table id="raumbuchung" class="raumbuchung">
	<tr>
		%loop_datum%
		<th colspan="%date_colspan%" class="datum">%datum%</th>
		<td></td>
		%/loop_datum%
	</tr>
	%optional bibliotheken%
	<tr style="display:none" class="bibliotheken-headline">
	%loop_bibliotheken%
		%bibliotheken_headlines%
		<td></td>
	%/loop_bibliotheken%
	%/optional bibliotheken%
	</tr>
	<tr>
		%loop_arbeitsplaetze% %arbeitsplaetze% %/loop_arbeitsplaetze%
	</tr>
	
	<!-- Maximale Anzahl Personen in Raum -->
	<tr style="text-align:center; height:24px;"> 
		%loop_userlimit% %userlimit% %/loop_userlimit%
	</tr>
	
	%loop_zeitabschnitte%
	<tr>
		%belegungen%		
	</tr>
	%/loop_zeitabschnitte%
</table>
</div>
</div>



