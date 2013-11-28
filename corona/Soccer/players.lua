

local centerX = display.contentCenterX
local centerY = display.contentCenterY

 player1 = display.newImage("player1.gif", centerX, centerY)

 player2 = display.newImage("player2.gif", centerX, centerY)

 player3 = display.newImage("player3.gif", centerX, centerY)
 local playerShape = {  -10, 10,  -10,-10,  10, -10, 10, 10}

local playerBody  = { density=0.8, friction=100, bounce=0, radius=15}

physics.addBody(player3, "dynamic", playerBody)
physics.addBody(player2, "dynamic", playerBody)
physics.addBody(player1, "dynamic", playerBody)
player1.myType = "player"
player2.myType = "player"
player3.myType = "player"

player1.isBullet = true
player2.isBullet = true
player3.isBullet = true

player1.xScale = .30
player1.yScale = .30
player2.xScale = .30
player2.yScale = .30
player3.xScale = .30
player3.yScale = .30

