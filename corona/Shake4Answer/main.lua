-----------------------------------------------------------------------------------------
--
-- main.lua
--
-----------------------------------------------------------------------------------------

---
--- Setup my world
---
local physics = require( "physics" )
physics.start()

local sky = display.newImage( "bkg_clouds.png", 160, 195 )

local ground = display.newImage( "ground.png", 160, 445 )

physics.addBody( ground, "static", { friction=0.1, bounce=0.7 } )


local name="tony"
---
--- Buffer up 4 sounds
--- 

local names = {}
names[1] = "tony"
names[2] = "cate"
names[3] = "kathy"


local sounds = {}

local shakes = 0

---
--- This stops the sound after 10 seconds
---
local stopAfter10Seconds = function()
        media.stopSound()
end

local startShake = 0
local shakeCount = 0

local countAfter2Seconds = function( )

   local rand = math.random( 3 ) 
   sounds[1] = "sounds/" .. names[rand] .. '/most-definitely.m4a'
   sounds[2] = "sounds/" .. names[rand] .. '/no-way.m4a' 
   sounds[3] = "sounds/" .. names[rand] .. '/maybe.m4a'

   print (shakeCount)
   print ( "play" .. sounds[shakeCount])
   media.playSound( sounds[shakeCount] )
   
   timer.performWithDelay( 20000, stopAfter10Seconds )
   shakeCount = 0
   startShake = 0

end



local widget = require( "widget" )

-- Function to handle button events
local function handleButtonEvent( event )

    if ( "ended" == event.phase ) then
        print( "Button was pressed and released" )
        playSound (1)
        shakeCount = event.target.shakeCount 
    end

end

-- Create the button
local yesButton = widget.newButton
{
    left = 100,
    top = 200,
    id = "yesButton",
  defaultFile = "buttonGray.png",
  overFile = "buttonBlue.png",
    label = "Yes",
    onEvent = handleButtonEvent
}
yesButton.shakeCount = 1


local noButton = widget.newButton
{
    left = 100,
    top = 160,
  defaultFile = "buttonGray.png",
  overFile = "buttonBlue.png",
    id = "noButton",
    label = "No",
    onEvent = handleButtonEvent
}
noButton.shakeCount = 2


local maybeButton = widget.newButton
{
    left = 100,
    top = 120,
  defaultFile = "buttonGray.png",
  overFile = "buttonBlue.png",
      id = "maybeButton",
    label = "Maybe",
    onEvent = handleButtonEvent
}
maybeButton.shakeCount = 3

 function playSound( answer )

  timer.performWithDelay( 200, countAfter2Seconds )

end
---
--- wait for the shake
---

local function listener( event )
    if event.isShake then

        if ( startShake == 0 ) then
           startShake = 1
           timer.performWithDelay( 2000, countAfter2Seconds )
	       print( "timer starts ")
        end

		local crate = display.newImage( "crate.png", 180, -50 )
		crate.rotation = 5

 	    shakeCount = (shakeCount % 3) + 1

	    print( "The device is being shaken! " )
        print( shakeCount )

        physics.addBody( crate, { density=1.0, friction=0.3, bounce=0.6 } )

    end
    return true
end

system.setAccelerometerInterval( 50 )

Runtime:addEventListener( "accelerometer", listener )


