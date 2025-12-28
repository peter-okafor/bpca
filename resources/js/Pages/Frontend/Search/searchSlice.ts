import { createSlice, PayloadAction } from '@reduxjs/toolkit'
import { ProviderInterface } from '@frontend/data/ProviderInterface'
import { RootState } from '@frontend/redux/store'
// import type { RootState } from '../../app/store'

// Define a type for the slice state

// Define the initial state using that type
const initialState: ProviderInterface[] = [];

export const searchSlice = createSlice({
  name: 'providerDetail',
  // `createSlice` will infer the state type from the `initialState` argument
  initialState,
  reducers: {
    // Use the PayloadAction type to declare the contents of `action.payload`
    
    saveProvidersList: (state, action: PayloadAction<ProviderInterface[]>) => {
      return [...action.payload];
    },
  },
})

export const { saveProvidersList } = searchSlice.actions

// Other code such as selectors can use the imported `RootState` type
export const selectProvider = (state: RootState) => state.providerDetail

export default searchSlice.reducer