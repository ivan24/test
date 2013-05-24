<?xml version='1.0' encoding='WINDOWS-1251'?>
<xsl:stylesheet version='1.0'
    xmlns:date="http://exslt.org/dates-and-times"
    extension-element-prefixes="date"
    xmlns:xsl='http://www.w3.org/1999/XSL/Transform'>
    <xsl:output  method="xml" encoding="WINDOWS-1251" indent="yes"/>

    <xsl:template match="/">
	<out>
Текущее время: <xsl:value-of select="date:date-time()"/>
Месяц: <xsl:value-of select="date:month-name()"/>
Номер недели: <xsl:value-of select="date:week-in-year()"/>
До конца года: <xsl:value-of
		  select="date:difference(date:date-time(),
			  '2004-12-31T23:59:59')"/>
А в секундах: <xsl:value-of
		  select="date:seconds(
				date:difference(date:date-time(),
				  '2004-12-31T23:59:59'))"/>
	</out>
    </xsl:template>

</xsl:stylesheet>
