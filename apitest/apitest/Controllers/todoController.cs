using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using System.Collections.Generic;
using System.Xml.Linq;

namespace apitest.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class todoController : ControllerBase
    {
        private static List<todoitem> _todos = new List<todoitem>
        {
            new todoitem { Id = 1, Name = "Do Laundry", IsComplete = false },
            new todoitem { Id = 2, Name = "Walk the dog", IsComplete = true }
        };

        [HttpGet]
        public ActionResult<List<todoitem>> GetAll()
        {
            return _todos;
        }

        ///[HttpGet("{id}", Name = "GetTodo")]
        ///public ActionResult<todoitem> GetById(int id)
        ////public ActionResult<todoitem> GetByName(string Name, ActionResult<todoitem> todo)
        ///{
            ///object v = _todos.Find(t => t.Name.Contains(Name)).ToList();
            ///var todo = v;
            //////if (todo == null)
            ///{
               //// return NotFound();
           /// }
           /// return (ActionResult<todoitem>)todo;
       /// }

        [HttpPost]
        public IActionResult Create(todoitem item)
        {
            item.Id = _todos.Count + 1;
            _todos.Add(item);

            return CreatedAtRoute("GetTodo", new { id = item.Id }, item);
        }

        [HttpPut("{id}")]
        public IActionResult Update(int id, todoitem item)
        {
            var todo = _todos.Find(t => t.Id == id);
            if (todo == null)
            {
                return NotFound();
            }

            todo.Name = item.Name;
            todo.IsComplete = item.IsComplete;

            return NoContent();
        }

        [HttpDelete("{id}")]
        public IActionResult Delete(int id)
        {
            var todo = _todos.Find(t => t.Id == id);
            if (todo == null)
            {
                return NotFound();
            }

            _todos.Remove(todo);
            return NoContent();
        }

        [HttpGet("GetByName")]
        public ActionResult<List<todoitem>> GetByName([FromQuery] string name)
        {
            var todos = _todos.Where(t => t.Name.Contains(name)).ToList();
            if (todos.Count == 0)
            {
                return NotFound();
            }
            return todos;
        }
    }
}
