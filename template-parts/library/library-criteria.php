<?php
/**
 * Library Criteria Classes
 * Implements Criteria Pattern for filtering documents
 */

class Criteria {
    protected $args = [];

    public function getArgs() {
        return $this->args;
    }

    public function combineWith(Criteria $other) {
        $this->args = array_merge_recursive($this->args, $other->getArgs());
        return $this;
    }
}

class CategoryCriteria extends Criteria {
    public function __construct($categories = []) {
        if (!empty($categories)) {
            $this->args['tax_query'][] = [
                'taxonomy' => 'categoria_documento',
                'field'    => 'slug',
                'terms'    => $categories,
                'operator' => 'IN',
            ];
        }
    }
}

class DateRangeCriteria extends Criteria {
    public function __construct($yearFrom = null, $yearTo = null) {
        if ($yearFrom || $yearTo) {
            $dateQuery = ['relation' => 'AND'];

            if ($yearFrom) {
                $dateQuery[] = [
                    'year' => $yearFrom,
                    'compare' => '>=',
                ];
            }

            if ($yearTo) {
                $dateQuery[] = [
                    'year' => $yearTo,
                    'compare' => '<=',
                ];
            }

            $this->args['date_query'] = $dateQuery;
        }
    }
}

class TitleSearchCriteria extends Criteria {
    public function __construct($searchTerm = '') {
        if (!empty($searchTerm)) {
            $this->args['s'] = sanitize_text_field($searchTerm);
        }
    }
}

class TypeCriteria extends Criteria {
    public function __construct($types = []) {
        if (!empty($types)) {
            $types_array = is_array($types) ? $types : [$types];

            $this->args['meta_query'][] = [
                'key'     => 'documento_tipo',
                'value'   => array_map('sanitize_text_field', $types_array),
                'compare' => 'IN',
            ];
        }
    }
}

class CriteriaBuilder {
    private $criteria = [];

    public function addCriteria(Criteria $criteria) {
        $this->criteria[] = $criteria;
        return $this;
    }

    public function build() {
        $combinedArgs = [
            'post_type'      => 'documento',
            'posts_per_page' => 9,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ];

        foreach ($this->criteria as $criteria) {
            $args = $criteria->getArgs();
            foreach ($args as $key => $value) {
                if ($key === 'tax_query' || $key === 'meta_query' || $key === 'date_query') {
                    if (!isset($combinedArgs[$key])) {
                        $combinedArgs[$key] = [];
                    }
                    if ($key === 'date_query' && isset($combinedArgs[$key]['relation'])) {
                        // Merge date_query properly
                        $combinedArgs[$key] = array_merge($combinedArgs[$key], $value);
                    } else {
                        $combinedArgs[$key] = array_merge($combinedArgs[$key], $value);
                    }
                } else {
                    $combinedArgs[$key] = $value;
                }
            }
        }

        return $combinedArgs;
    }
}
?>