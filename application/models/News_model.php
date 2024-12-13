<?php
class News_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url');
    }

    // View published news in the Homepage
    public function get_published_news()
    {
        $this->db->where('status', 'published');
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('news_articles');

        return $query->result_array();
    }

    // View a single published news by logged in reader
    public function get_news_by_slug($slug)
    {
        $this->db->select('news_articles.*, categories.category as category_name, 
            users.first_name as first_name, users.last_name as last_name, GROUP_CONCAT(tags.tag) as tag_names');
        $this->db->from('news_articles');
        $this->db->join('categories', 'news_articles.category_id = categories.id', 'left');
        $this->db->join('tags', 'news_articles.tag_id = tags.id', 'left');
        $this->db->join('users', 'news_articles.journalist_id = users.id', 'left');
        $this->db->where('news_articles.slug', $slug);
        $this->db->group_by('news_articles.id');
        $query = $this->db->get();

        return $query->row_array();
    }


    // Add news by journalists
    public function insert_article($news_data)
    {
        return $this->db->insert('news_articles', $news_data);
    }

    // View news written by a journalist
    public function get_articles_by_journalist($journalist_id)
    {
        $this->db->select('news_articles.*, categories.category as category');
        $this->db->from('news_articles');
        $this->db->where('news_articles.journalist_id', $journalist_id);
        $this->db->where('deleted_at IS NULL');
        $this->db->join('categories', 'news_articles.category_id = categories.id', 'INNER');
        $this->db->order_by('news_articles.created_at', 'DESC');

        $query = $this->db->get();

        return $query->result_array();
    }

    // Pull category list into add news form
    public function get_all_categories()
    {
        $query = $this->db->get('categories');
        return $query->result_array();
    }

    // Pull tags list into add news form
    public function get_all_tags()
    {
        $query = $this->db->get('tags');
        return $query->result_array();
    }

    // View a single news from a journalist
    public function get_news_by_id($id)
    {
        $this->db->select('news_articles.*, categories.category as category_name, GROUP_CONCAT(tags.tag SEPARATOR ", ") as tag_names');
        $this->db->from('news_articles');
        $this->db->join('categories', 'news_articles.category_id = categories.id', 'left');
        $this->db->join('tags', 'news_articles.tag_id = tags.id', 'left');
        $this->db->where('news_articles.id', $id);
        // $this->db->group_by('news_articles.id');
        $query = $this->db->get();

        return [
            'result' => $query->row_array(),
        ];
    }

    public function update_news($id, $news_data, $tag_id = [])
    {
        $this->db->trans_start();

        $this->db->where('id', $id);
        $this->db->update('news_articles', $news_data);

        // if (!empty($tag_id)) {
        //     $this->db->where('news_article_id', $id);
        //     $this->db->delete('news_article_tags');

        //     // Insert new tags
        //     foreach ($tag_ids as $tag_id) {
        //         $this->db->insert('news_article_tags', [
        //             'news_article_id' => $id,
        //             'tag_id' => $tag_id,
        //         ]);
        //     }
        // }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }


    // Delete a news article by journalist
    public function delete_news_article($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('news_articles', ['deleted_at' => date('Y-m-d H:i:s')]);
    }

    // View all news articles in editor-dashboard
    public function get_submitted_news()
    {
        $this->db->select('news_articles.*, categories.category as category_name, 
            users.first_name as first_name, users.last_name as last_name, GROUP_CONCAT(tags.tag) as tag_names');
        $this->db->from('news_articles');

        $this->db->join('categories', 'news_articles.category_id = categories.id', 'left');
        $this->db->join('users', 'news_articles.journalist_id = users.id', 'left');
        $this->db->join('tags', 'news_articles.tag_id = tags.id', 'left');
        // $this->db->where('news_articles.status', 'pending');
        $this->db->order_by('updated_at', 'DESC');
        $this->db->group_by('news_articles.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    // View single news article in review page by editor
    public function get_single_submitted_news($id)
    {
        $this->db->select('news_articles.*, categories.category as category_name, 
            users.first_name as first_name, users.last_name as last_name, GROUP_CONCAT(tags.tag) as tag_names');
        $this->db->from('news_articles');
        $this->db->join('categories', 'news_articles.category_id = categories.id', 'left');
        $this->db->join('users', 'news_articles.journalist_id = users.id', 'left');
        $this->db->join('tags', 'news_articles.tag_id = tags.id', 'left');
        $this->db->where('news_articles.id', $id);
        // $this->db->group_by('news_articles.id');
        $query = $this->db->get();
        return $query->row_array();
    }

    // Update the status of news_article after reviewed by editor
    public function update_news_status($news_id, $status)
    {
        $data = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id', $news_id);
        $this->db->update('news_articles', $data);
    }

    // Publish news article by journalist
    public function update_news_status_to_published($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('news_articles', $data);
    }

    // Get news headline for homepage
    public function get_latest_news($limit = 5)
    {
        $this->db->select('title, created_at');
        $this->db->from('news_articles');
        $this->db->where('status', 'published');
        $this->db->where('updated_at >=', date('Y-m-d H:i:s', strtotime('-24 hours')));
        $this->db->order_by('updated_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    // Get news by categories in homepage
    public function get_all_news_by_category($category_name)
    {
        $this->db->select('news_articles.*, categories.category as category_name');
        $this->db->from('news_articles');
        $this->db->join('categories', 'news_articles.category_id = categories.id', 'left');
        $this->db->where('status', 'published');
        $this->db->where('categories.category', $category_name);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();

        return $query->result_array();
    }
}
