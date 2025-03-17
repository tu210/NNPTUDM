var express = require('express');
var router = express.Router();
var Category = require('../schemas/category');

// Create category
router.post('/', async (req, res) => {
    try {
        var category = new Category(req.body);
        var savedCategory = await category.save();
        res.status(201).json(savedCategory);
    } catch (error) {
        res.status(400).json({ message: error.message });
    }
});

// Get all categories
router.get('/', async (req, res) => {
    try {
        var categories = await Category.find();
        res.status(200).json(categories);
    } catch (error) {
        res.status(500).json({ message: error.message });
    }
});

// Get category by ID
router.get('/:id', async (req, res) => {
    try {
        var category = await Category.findById(req.params.id);
        if (!category) {
            return res.status(404).json({ message: 'Category not found' });
        }
        res.status(200).json(category);
    } catch (error) {
        res.status(500).json({ message: error.message });
    }
});

// Update category
router.put('/:id', async (req, res) => {
    try {
        var category = await Category.findByIdAndUpdate(
            req.params.id,
            req.body,
            { new: true }
        );
        if (!category) {
            return res.status(404).json({ message: 'Category not found' });
        }
        res.status(200).json(category);
    } catch (error) {
        res.status(400).json({ message: error.message });
    }
});

// Delete category
router.delete('/:id', async (req, res) => {
    try {
        var category = await Category.findByIdAndDelete(req.params.id);
        if (!category) {
            return res.status(404).json({ message: 'Category not found' });
        }
        res.status(200).json({ message: 'Category deleted successfully' });
    } catch (error) {
        res.status(500).json({ message: error.message });
    }
});

module.exports = router;