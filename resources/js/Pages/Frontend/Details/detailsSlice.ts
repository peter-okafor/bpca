import { createSlice, PayloadAction } from '@reduxjs/toolkit'
import { ProviderInterface } from '@frontend/data/ProviderInterface'
import { RootState } from '@frontend/redux/store'
// import type { RootState } from '../../app/store'

// Define a type for the slice state

// Define the initial state using that type
const initialState: ProviderInterface = {
  id: 0,
  name: '',
  address_1: '',
  address_2: '',
  logo_url: '',
  email: '',
  mobile: '',
  telephone: '',
  website: '',
  premises_type: '',
  postcode: '',
  town: '',
  features: [],
  geodata: {
    type: '',
    coordinates: [],
  },
  services: []
}

export const providerDetailsSlice = createSlice({
  name: 'providerDetail',
  // `createSlice` will infer the state type from the `initialState` argument
  initialState,
  reducers: {
    // Use the PayloadAction type to declare the contents of `action.payload`
    
    saveProvider: (state, action: PayloadAction<ProviderInterface>) => {
      state = {...state, ...action.payload}
      return state
    },
  },
})

export const { saveProvider } = providerDetailsSlice.actions

// Other code such as selectors can use the imported `RootState` type
export const selectProvider = (state: RootState) => state.providerDetail

export default providerDetailsSlice.reducer