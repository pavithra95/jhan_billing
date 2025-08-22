<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function salesQuantity()
    {
         return $this->hasMany(SalesInvoiceItem::class,'item_id','id')
         ->sum('quantity');
     }
	 
	 public function saleAmount()
    {
         return $this->hasMany(SalesInvoiceItem::class,'item_id','id')
         ->sum('total_amount');
    }
	 public function salecessAmount()
    {
         return $this->hasMany(SalesInvoiceItem::class,'item_id','id')
         ->sum('cess_total_amount');
    }
	 public function salegstAmount()
    {
         return $this->hasMany(SalesInvoiceItem::class,'item_id','id')
         ->sum('gst_total_amount');
    }
	public function saleigstAmount()
    {
         return $this->hasMany(SalesInvoiceItem::class,'item_id','id')
         ->sum('igst_total_amount');
    }
	public function saletaxableAmount()
    {
         return $this->hasMany(SalesInvoiceItem::class,'item_id','id')
         ->sum('taxable_amount');
    }
    
	 public function salesreturnQuantity()
    {
         return $this->hasMany(SalesReturnInvoiceItem::class,'item_id','id')
         ->sum('quantity');
    }
	 
    public function cashQuantity()
    {
         return $this->hasMany(CashBillInvoiceItem::class,'item_id','id')
         ->sum('quantity');
     }
     
     public function cashAmount()
    {
         return $this->hasMany(CashBillInvoiceItem::class,'item_id','id')
         ->sum('total_amount');
    }

	 public function cashcessAmount()
    {
         return $this->hasMany(CashBillInvoiceItem::class,'item_id','id')
         ->sum('cess_total_amount');
    }
	public function cashgstAmount()
    {
         return $this->hasMany(CashBillInvoiceItem::class,'item_id','id')
         ->sum('gst_total_amount');
    }
	
	public function cashtaxableAmount()
    {
         return $this->hasMany(CashBillInvoiceItem::class,'item_id','id')
         ->sum('taxable_amount');
    }

      public function purchaseQuantity()
     {
         return $this->hasMany(PurchaseInvoiceItem::class,'item_id','id')
         ->sum('quantity');
     } 
	 
	  public function purchasereturnQuantity()
     {
         return $this->hasMany(PurchaseReturnInvoiceItem::class,'item_id','id')
         ->sum('quantity');
     }
	 
     public function purchaseAmount()
    {
         return $this->hasMany(PurchaseInvoiceItem::class,'item_id','id')
         ->sum('amount');
    }
	
	 public function purchasereturnAmount()
    {
         return $this->hasMany(PurchaseReturnInvoiceItem::class,'item_id','id')
         ->sum('amount');
    }
	
	 public function netAmount()
    {
         return $this->purchaseAmount() - $this->purchasereturnAmount();
    }
    
    public function salecashbillgsttotalAmount()
    {
         return $this->salegstAmount() + $this->cashgstAmount();
    }
	
     /*public function totalSaleQuantity()
     {
         return $this->salesQuantity() + $this->cashQuantity();
     }*/
	 
	 public function totalSaleQuantity()
     {
         return $this->salesQuantity() + $this->cashQuantity() - $this->salesreturnQuantity();
     }

     public function cashstockQuantity()
     {
     	return $this->purchaseQuantity() - $this->cashQuantity();
     } 
	 
	 /*public function stockQuantity()
     {
        return $this->purchaseQuantity() - $this->totalSaleQuantity();
     }*/
	 
     public function stockQuantity()
     {
        return $this->purchaseQuantity() - $this->totalSaleQuantity() - $this->purchasereturnQuantity() + $this->salesreturnQuantity();
     }
	 
	 public function stockavilableQuantity()
     {
        return $this->purchaseQuantity() - $this->purchasereturnQuantity() - $this->totalSaleQuantity();
     }
	 
	 public function returnstockQuantity()
     {
        return $this->purchaseQuantity() - $this->purchasereturnQuantity();
     }
	 
     public function Category()
     {
         return $this->hasOne(ProductCategory::class, 'id' , 'category_id');
     }
     public function subcategory()
     {
         return $this->hasOne(SubCategory::class, 'id' , 'subcategory_id');
     }
	 
     public function ProductTax()
     {
         return $this->hasOne(TaxGroup::class, 'id' , 'gst_id');
     } 
	 
     public function IgstProductTax()
     {
         return $this->hasOne(TaxGroup::class, 'id' , 'igst_id');
     } 
	 
     public function CessProductTax()
     {
         return $this->hasOne(TaxGroup::class, 'id' , 'cess_id');
     } 
	 
     public function taxGroup()
     {
         return $this->hasMany(TaxGroupItem::class,'tax_group_id','gst_id' );
     } 
	 
     public function igsttaxGroup()
     {
         return $this->hasMany(TaxGroupItem::class,'tax_group_id','igst_id' );
     } 
	 
     public function cesstaxGroup()
     {
         return $this->hasMany(TaxGroupItem::class,'tax_group_id','cess_id' );
     }
	 
     public function Unit()
     {
         return $this->hasOne(Unit::class,'id','unit_id' );
     } 
     public function Size()
     {
         return $this->hasOne(Size::class,'id','size');
     }

     
     
}
