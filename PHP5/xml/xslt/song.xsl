<?xml version='1.0' encoding='WINDOWS-1251'?>
<xsl:stylesheet version='1.0'
     xmlns:xsl='http://www.w3.org/1999/XSL/Transform'>

    <!-- Значение параметра n по-умолчанию -->
    <xsl:param name='n'>0</xsl:param>
    <xsl:template name='song' match='Песня'>
	<h2>Песня N<xsl:value-of select='$n'/>:
	    <xsl:value-of select='./@название'/></h2>
	<table>
	    <xsl:for-each select="Куплет">
		<tr>
		    <th align='right' valign='top'>Куплет</th>
		    <td><xsl:apply-templates select="."/></td>
		 </tr>
		<tr>
		    <th align='right' valign='top'>Припев</th>
		    <td><xsl:apply-templates select="../Припев"/></td>
		 </tr>
	    </xsl:for-each>
	    <tr>
		<th align='right' valign='top'>Конец</th>
		<td><xsl:call-template name='final'/></td>
	    </tr>
	</table>
    </xsl:template>
</xsl:stylesheet>
