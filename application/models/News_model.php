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
        return $this->db->where('status', 'published')
            ->where('deleted_at IS NULL')
            ->order_by('created_at', 'DESC')
            ->get('news_articles')
            ->result_array();
    }

    // View a single published news by logged in reader
    public function get_news_by_slug($slug)
    {
        return $this->db->select('news_articles.*, categories.category as category_name, 
                              users.first_name, users.last_name, GROUP_CONCAT(tags.tag) as tag_names')
            ->from('news_articles')
            ->join('categories', 'news_articles.category_id = categories.id', 'left')
            ->join('tags', 'news_articles.tag_id = tags.id', 'left')
            ->join('users', 'news_articles.journalist_id = users.id', 'left')
            ->where('news_articles.slug', $slug)
            ->group_by('news_articles.id')
            ->get()
            ->row_array();
    }


    // Add news by journalists
    public function insert_article($news_data)
    {
        return $this->db->insert('news_articles', $news_data);
    }

    // View news written by a journalist
    public function get_articles_by_journalist($journalist_id)
    {
        return $this->db->select('news_articles.*, categories.category as category')
            ->from('news_articles')
            ->join('categories', 'news_articles.category_id = categories.id', 'inner')
            ->where('news_articles.journalist_id', $journalist_id)
            ->where('deleted_at IS NULL')
            ->order_by('news_articles.created_at', 'DESC')
            ->get()
            ->result_array();
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
        return $this->db->select('news_articles.*, categories.category as category_name, GROUP_CONCAT(tags.tag SEPARATOR ", ") as tag_names')
            ->from('news_articles')
            ->join('categories', 'news_articles.category_id = categories.id', 'left')
            ->join('tags', 'news_articles.tag_id = tags.id', 'left')
            ->where('news_articles.id', $id)
            ->group_by('news_articles.id')
            ->get()
            ->row_array();
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
        return $this->db->select('news_articles.*, categories.category as category_name, 
            users.first_name, users.last_name, GROUP_CONCAT(tags.tag) as tag_names')
            ->from('news_articles')
            ->join('categories', 'news_articles.category_id = categories.id', 'left')
            ->join('users', 'news_articles.journalist_id = users.id', 'left')
            ->join('tags', 'news_articles.tag_id = tags.id', 'left')
            ->group_by('news_articles.id')
            ->order_by('updated_at', 'DESC')
            ->get()
            ->result_array();
    }

    // View single news article in review page by editor
    public function get_single_submitted_news($id)
    {
        return $this->db->select('news_articles.*, categories.category as category_name, 
            users.first_name, users.last_name, GROUP_CONCAT(tags.tag) as tag_names')
            ->from('news_articles')
            ->join('categories', 'news_articles.category_id = categories.id', 'left')
            ->join('users', 'news_articles.journalist_id = users.id', 'left')
            ->join('tags', 'news_articles.tag_id = tags.id', 'left')
            ->where('news_articles.id', $id)
            ->get()
            ->row_array();
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
        return $this->db->select('title, created_at')
            ->from('news_articles')
            ->where(['status' => 'published', 'deleted_at' => NULL])
            ->where('updated_at >=', date('Y-m-d H:i:s', strtotime('-24 hours')))
            ->order_by('updated_at', 'DESC')
            ->limit($limit)
            ->get()
            ->result_array();
    }

    // Get news by categories in homepage
    public function get_all_news_by_category($category_name)
    {
        return $this->db->select('news_articles.*, categories.category as category_name')
            ->from('news_articles')
            ->join('categories', 'news_articles.category_id = categories.id', 'left')
            ->where(['status' => 'published', 'deleted_at' => NULL, 'categories.category' => $category_name])
            ->order_by('created_at', 'DESC')
            ->get()
            ->result_array();
    }
}
