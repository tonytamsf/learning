-- Virus Spawner

require "spawn"

---
------------------------------------------------------------------------
-- Setup our main screen
------------------------------------------------------------------------
local centerX = display.contentCenterX
local centerY = display.contentCenterY
local _W = display.contentWidth
local _H = display.contentHeight

local physics = require("physics")
physics.start()
display.setStatusBar( display.HiddenStatusBar )
local bkg = display.newImage( "images/bkg_cor.png", centerX, centerY )

local grass = display.newImage("images/grass.png", 160, 430 )

local grass2 = display.newImage("images/grass2.png", 160, 440 ) -- non-physical decorative overlay

physics.addBody( grass, "static", { friction=0.5, bounce=0.3 } )

------------------------------------------------------------------------
-- Drop 100 crates
------------------------------------------------------------------------
local dropCrates = timer.performWithDelay( 500, spawn.new, 100 )