<?xml version='1.0' encoding='WINDOWS-1251'?>
<xsl:stylesheet version='1.0'
     xmlns:xsl='http://www.w3.org/1999/XSL/Transform'>

    <xsl:output  method="xml" encoding="WINDOWS-1251" indent="yes"/>
    <xsl:param name="nsong">0</xsl:param>

    <xsl:template match='/'><!-- главный шаблон -->
	<head>
	<link rel='stylesheet' type='text/css' href='style.css'/>
	<title>Лучшие песни :-)</title>
	</head>
	<body>
	    <table align='center' width='100%'><tr>
		<xsl:for-each select='Песни/Песня'>
		    <xsl:sort select="@id" order='descending'/>
		    <xsl:variable name="n" select="$nsong+position()"/>
		    <td valign='top' align='center'>
			<div class='song'>
			    <xsl:call-template name='song'>
				<xsl:with-param name='n' select="$n"/>
			    </xsl:call-template>
			</div>
		    </td>
		</xsl:for-each>
	    </tr></table>
	</body>
    </xsl:template>

</xsl:stylesheet>

