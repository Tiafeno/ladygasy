export declare interface GroupAttribute {
  id_product_group: number,
  type: string,
  name: string,
  slug_name: string,
  is_color: number
}

export declare interface Product {
  id_product: number,
  name: string,
  slug_name: string,
  type: string,
  ean13: string,
  quantity: number,
  minimal_quantity: number,
  reference: string,
  active: number,
  price: number,
  description: string,
  description_short: string
}

export declare interface Attribute {
  id_attribute: number,
  id_group: number,
  name: string
}
