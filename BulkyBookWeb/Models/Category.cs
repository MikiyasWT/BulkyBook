using System.ComponentModel.DataAnnotations;

namespace BulkyBookWeb.Models
{
    public class Category
    {
            [Key]
            public int Id { get; set; }
            [Required]
            public String Name { get; set; }

            [Display(Name="Display order")]
            [Range(1,100,ErrorMessage ="range can't be less than 1 and exceed 100")]
            public int DisplayOrder { get; set; }
            public DateTime CreatedDateTime { get; set; } = DateTime.Now;
    }
}
