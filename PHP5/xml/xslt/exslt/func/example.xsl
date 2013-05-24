<?xml version='1.0' encoding='WINDOWS-1251'?>
<xsl:stylesheet version='1.0'
    xmlns:func="http://exslt.org/functions"
    xmlns:my="http://www.nevod.ru/staff/kaf/exslt"
    extension-element-prefixes="func"
    xmlns:xsl='http://www.w3.org/1999/XSL/Transform'>
    <xsl:output  method="xml" encoding="WINDOWS-1251" indent="yes"/>

    <func:function name="my:count_elements_attributes">
	<xsl:variable name="elements" select="//*"/>
	<xsl:variable name="attributes" select="//@*"/>
	<func:result select="count($elements | $attributes)"/>
    </func:function>

  <xsl:template match="/">
    <Элементы_и_атрибуты>
    <Элементов><xsl:value-of select="count(//*)"/></Элементов>
    <Атрибутов><xsl:value-of select="count(//@*)"/></Атрибутов>
    <Всего>
	<xsl:value-of select="my:count_elements_attributes()"/>
    </Всего>
    </Элементы_и_атрибуты>
  </xsl:template>

</xsl:stylesheet>
