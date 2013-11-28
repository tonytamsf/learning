
-- A basic function for dragging physics objects
function startMove( event )
	local t = event.target
	if ( t ) then
		lastTouched = event.target
	else
		t = lastTouched
    end

    if (t == nil) then
    	return false
    end

	local xDirection
	local yDirection

	print ( "hit")
	if (t.x < event.x) then
		xDirection = 1
	else
		xDirection = -1
	end

	if (t.y < event.y) then
		yDirection = 1
	else
		yDirection = -1
	end

    t:applyForce( xDirection * .1, yDirection * .1, t.x, t.y )

	-- Stop further propagation of touch event!
	return true
end