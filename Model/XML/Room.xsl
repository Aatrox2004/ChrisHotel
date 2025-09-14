<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" encoding="UTF-8"/>
  <xsl:template match="/">
    <div class="rooms-container">
      <xsl:for-each select="rooms/room">
        <div class="room-card">
          <h3 class="room-number">Room <xsl:value-of select="room_number"/></h3>
          <p class="room-type"><strong>Type:</strong> <xsl:value-of select="room_type"/></p>
          <p class="room-price"><strong>Price:</strong> $<xsl:value-of select="price"/> per night</p>
          <p class="room-status"><strong>Status:</strong> <xsl:value-of select="status"/></p>
          <p class="room-description"><xsl:value-of select="description"/></p>
          <xsl:if test="status = 'Available'">
            <button class="select-room-btn">
              <xsl:attribute name="onclick">selectRoom('<xsl:value-of select="room_number"/>')</xsl:attribute>
              Select Room
            </button>
          </xsl:if>
        </div>
      </xsl:for-each>
    </div>
  </xsl:template>
</xsl:stylesheet>