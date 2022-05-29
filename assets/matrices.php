<?php

function getMatrixMax($matrix)
{
    // Write some code to traverse all the elements in the matrix and return the biggest number!
    return max($matrix[0]);
}

$matrixPositive = [
    [10, 100, 3],
    [12, 200, 154],
    [3, 30, 2],
];

$matrixMixed = [
    [-10, 100, 3],
    [12, -200, 154],
    [3, 30, -2],
];

$matrixNegative = [
    [-10, -100, -3],
    [-12, -200, -154],
    [-3, -30, -2],
];

echo getMatrixMax($matrixPositive).PHP_EOL; // Should return 200
echo getMatrixMax($matrixMixed).PHP_EOL; // Should return 154
echo getMatrixMax($matrixNegative).PHP_EOL; // Should return -2
