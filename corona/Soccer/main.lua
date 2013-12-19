local physics = require( "physics" )

physics.start() 

local drag = require("drag")
local kick = require("kick")
local move = require("move")

local centerX = display.contentCenterX
local centerY = display.contentCenterY
local _W = display.contentWidth
local _H = display.contentHeight


physics.setContinuous(true)
physics.setScale( 60 ) -- a value that seems good for small objects (based on playtesting)
physics.setGravity( 1, 1 ) -- overhead view, therefore no gravity vector
physics.setVelocityIterations( 100 )
physics.setAverageCollisionPositions( true )
physics.setPositionIterations( 16 )

display.setStatusBar( display.HiddenStatusBar )

local borderHorizontalShape = { -960, -5, -960, 5, 960, 5, 960, -5}

local background = display.newImage("soccer-field.png", centerX, centerY)
local topBorder = display.newImage("border-horizontal.png", centerX, 1, borderHorizontalShape)
local bottomBorder = display.newImage("border-horizontal.png", centerX, _H - 1, borderHorizontalShape)

local rightBorder = display.newImage("border-vertical.png", 1, centerY)
local leftBorder = display.newImage("border-vertical.png", _W-1, centerY)

require("players")

local ball = display.newImage("football.png", centerX, centerY)
local ballBody = { density=0.3, friction=0.1, bounce=0.3, radius=10 }
local borderBody = { density=0.2, friction=0.9, bounce=0}
ball.myName = 'ball'

ball.linearDamping = 0.3
ball.angularDamping = 0.8
ball.isBullet = true -- force continuous collision detection, to stop really fast shots from passing through other balls


target = display.newImage( "target.png" )
target.x = ball.x; target.y = ball.y; target.alpha = 0

physics.addBody(topBorder, "static", borderBody)
physics.addBody(bottomBorder, "static", borderBody)
physics.addBody(rightBorder, "static", borderBody)
physics.addBody(leftBorder, "static", borderBody)

physics.addBody(ball, "dynamic", ballBody)


local function onCollision( event )
	if ( event.phase == "began" ) then
    	if (event.object1.myType == "player" and event.object2.myName == "ball" ) then
	       ball:applyForce( math.min(ball.x - event.x, 1), math.min(ball.y - event.y, 1), event.x, event.y )
	       print ( "collision")
	    end
    elseif ( event.phase == "ended" ) then

    end

end

Runtime:addEventListener( "collision", onCollision )

-- Activate the cue ball and start playing!
--ball:addEventListener( "touch", kickBall )
player1:addEventListener( "touch", startDrag )
player2:addEventListener( "touch", startDrag )
