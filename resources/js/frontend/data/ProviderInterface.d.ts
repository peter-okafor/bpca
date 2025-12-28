export interface ProviderInterface {
  id: number
  name: string
  address_1: string
  address_2: string
  logo_url: string
  email: string
  mobile: string
  telephone: string
  website: string
  premises_type: string
  postcode: string
  town: string
  features: string[];
  geodata: GeodataInterface
  services: ServiceInterface[]
  contact_hours?: string
  description?: string
  accreditation_year?: string;
  pests?: PestInterface[]
}

interface GeodataInterface {
  type: string
  coordinates: number[]
}

interface PestInterface {
  id: string;
  name: string;
  code: string;
  description: string;
}

interface ServiceInterface {
  id: number
  name: string
}