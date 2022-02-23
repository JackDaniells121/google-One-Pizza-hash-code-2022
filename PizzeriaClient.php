<?php
namespace GoogleHashCode2022Solution;

class PizzeriaClient {

    public function __construct(
        public array $like = [],
        public array $dislike = [],
        public float $likeScore = 0,
        public float $dislikeScore = 0
    ) {
        
    }
}

