<?php

/*
 * formats a float in a reasonable consistent way
 */
function number_to_string($number, $precision=2) {
	return number_format($number, $precision, ".", "");
}
