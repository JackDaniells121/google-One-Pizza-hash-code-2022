<?php
namespace GoogleHashCode2022Solution;

class PizzeriaClientCollection {


    public function __construct(
        public array $clients = [],
        public array $allLike = [],
        public array $allDislike = [],
        public array $allLikeFreq = [],
        public array $allDislikeFreq = [],
        public array $mostLikesDislikes = []
    ) {
        $this->allLike = $this->getAllLike();
        $this->allDislike = $this->getAllDislike();
        $this->allLikeFreq = array_count_values($this->allLike);
        $this->allDislikeFreq = array_count_values($this->allDislike);

        $this->getAllClientsScore();
    }

    public function getAllLike(): array {
        $result = [];
        foreach ($this->clients as $client) {
            $result = array_merge($result, $client->like);
        }
        return $result;
    }
    public function getAllDislike(): array {
        $result = [];
        foreach ($this->clients as $client) {
            $result = array_merge($result, $client->dislike);
        }
        return $result;
    }

    public function getAllClientsScore() {

        foreach ($this->clients as &$client) {
            $likeCount = count($client->like);
            foreach ($client->like as $like) {
                $client->likeScore += $this->allLikeFreq[$like] / $likeCount;
            }
            $dislikeCount = count($client->dislike);
            foreach ($client->dislike as $dislike) {
                $client->dislikeScore += $this->allDislikeFreq[$dislike] * $dislikeCount;
            }

        }
    }

    public function calculateScore($resultArray) {
        $score = 0;

        foreach ($this->clients as $client) {

            $dislikeFit = !array_diff($client->dislike, $resultArray);

            if ($dislikeFit && count($client->dislike) != 0) {
                continue;
            }

            $likeFit = !array_diff($client->like, $resultArray);

            if ($likeFit) {
                $score++;
            }
        }
        return $score;
    }

    public function calculateMostLikeDislike() {
        foreach ($this->allLike as $like) {
            if(!array_key_exists($like, $this->allDislikeFreq))
            {
                $this->mostLikesDislikes[] = $like;
                continue;
            }

            if($this->allLikeFreq[$like] > $this->allDislikeFreq[$like])
            {
               $this->mostLikesDislikes[] = $like;
            }
        }
    }
}

