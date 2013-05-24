<xsl:template match='тропа'>
    <!-- действия -->
    <элемент1 атрибут="значение" ...> текст
	<элемент2 атрибут="значение" ...> текст
	    ...
	    <xsl:apply-templates select="тропа"/>
	    ...
	</элемент2>
	<xsl:call-template name="имя">
	    <xsl:with-param name="...">...</xsl:with-param>
	    <xsl:with-param name="...">...</xsl:with-param>
	    ...
	</xsl:call-template>
	...
	<xsl:apply-templates select="тропа">
	    <xsl:with-param name="...">...</xsl:with-param>
	    <xsl:with-param name="...">...</xsl:with-param>
	...
	</xsl:call-templates>
    </элемент1>
    ...
