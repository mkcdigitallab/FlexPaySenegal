export interface User {
    id: number
    name: string
    phone: string
    role: 'client' | 'agent' | 'admin'
}

export interface Wallet {
    id: number
    user_id: number
    balance: string | number
    currency: string
}

export interface Transaction {
    id: number
    wallet_id: number
    recipient_wallet_id: number | null
    type: 'deposit' | 'withdrawal' | 'transfer'
    amount: string | number
    fee: string | number
    status: 'pending' | 'completed' | 'failed'
    reference: string
    description: string | null
    completed_at: string | null
    created_at: string
}

export interface PaginatedTransactions {
    data: Transaction[]
    current_page: number
    last_page: number
    total: number
}

export type TransactionCollection =
    | Transaction[]
    | PaginatedTransactions