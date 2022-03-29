using Microsoft.AspNetCore.Mvc;
using BulkyBookWeb.Data;
using BulkyBookWeb.Models;
using Microsoft.EntityFrameworkCore;
using System.Linq;

namespace BulkyBookWeb.Controllers
{
    public class CategoryController : Controller
    {
        private readonly ApplicationDbContext _db;

        public CategoryController(ApplicationDbContext db)
        {
            _db = db;
        }
        public IActionResult Index()
        {
            IEnumerable<Category> objCategoryList = _db.Categories;
            return View(objCategoryList);
        }

        [HttpGet]
        public IActionResult Create()
        {
            return View();
        }

        // GET: Categories/Details
        public async Task<IActionResult> Details(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var category = await _db.Categories
                .FirstOrDefaultAsync(m => m.Id == id);
            if (category == null)
            {
                return NotFound();
            }

            return View(category);
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public IActionResult Create(Category obj)
        {
            if (obj.Name == obj.DisplayOrder.ToString())
            {
                ModelState.AddModelError("customError", "Display order can't excatly match Name");
            }
            if (ModelState.IsValid)
            {
                _db.Categories.Add(obj);
                _db.SaveChanges();
                TempData["success"] = "category created successfully";
                return RedirectToAction("Index");
            }
            return View(obj);
        }

        [HttpGet]
        public IActionResult Edit(int? id)
        {
            if(id == null || id == 0)
            {
                return NotFound();
            }
            var categoryFromdb = _db.Categories.Find(id);
            //var categoryFromdb = _db.Categories.FirstOrDefault(u => u.Id==id);
            if (categoryFromdb == null)
            {
                return NotFound();
            }
            return View(categoryFromdb);
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public IActionResult Edit(Category obj)
        {
            if (obj.Name == obj.DisplayOrder.ToString())
            {
                ModelState.AddModelError("customError", "Display order can't excatly match Name");
            }
            if (ModelState.IsValid)
            {
                _db.Categories.Update(obj);
                _db.SaveChanges();
                TempData["success"] =  "category Updated successfully";
                return RedirectToAction("Index");
            }
            return View(obj);
        }

        [HttpGet]
        public IActionResult Search(String? name)
        {
            if (string.IsNullOrEmpty(name))
            {
                TempData["fail"] = "couldn't find anyting that match your search";
                return NotFound();
            }
            var bookNamefrombd = _db.Categories.Find(name.ToString());
            return View();
        }



        [HttpGet]
        public IActionResult Delete(int? id)
        {
            if (id == null || id == 0)
            {
                return NotFound();
            }
            var categoryFromdb = _db.Categories.Find(id);
            //var categoryFromdb = _db.Categories.FirstOrDefault(u => u.Id==id);
            if (categoryFromdb == null)
            {
                return NotFound();
            }
            return View(categoryFromdb);
        }

      [HttpPost]
      [ValidateAntiForgeryToken]
      public IActionResult DeleteCategory(int? id)
        {
            var objfromdb = _db.Categories.Find(id);
            if (objfromdb == null)
            {
                return NotFound();
            }
            _db.Categories.Remove(objfromdb);
            _db.SaveChanges();
            TempData["success"] = "category Deleted successfully";
            return RedirectToAction("Index");
        }
    }
}
